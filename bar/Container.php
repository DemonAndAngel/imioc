<?php 
//������װʵ�����ṩʵ���Ļص�����
class Container {

    //����װ�ṩʵ���Ļص���������������������װʵ������������
    //�Ӷ�ʵ�ֵ����ȸ߼�����
    protected $bindings = [];

    //�󶨽ӿں�������Ӧʵ���Ļص�����
    public function bind($abstract, $concrete=null, $shared=false) {
        
        //����ṩ�Ĳ������ǻص������������Ĭ�ϵĻص�����
        if(!$concrete instanceof Closure) {
            $concrete = $this->getClosure($abstract, $concrete);
        }
        
        $this->bindings[$abstract] = compact('concrete', 'shared');
    }

    //Ĭ������ʵ���Ļص�����
    protected function getClosure($abstract, $concrete) {
        
        return function($c) use ($abstract, $concrete) {
            $method = ($abstract == $concrete) ? 'build' : 'make';
            return $c->$method($concrete);
        };
        
    }

    public function make($abstract) {
        $concrete = $this->getConcrete($abstract);

        if($this->isBuildable($concrete, $abstract)) {
            $object = $this->build($concrete);
        } else {
            $object = $this->make($concrete);
        }
        
        return $object;
    }

    protected function isBuildable($concrete, $abstract) {
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    //��ȡ�󶨵Ļص�����
    protected function getConcrete($abstract) {
        if(!isset($this->bindings[$abstract])) {
            return $abstract;
        }

        return $this->bindings[$abstract]['concrete'];
    }

    //ʵ��������
    public function build($concrete) {

        if($concrete instanceof Closure) {
            return $concrete($this);
        }

        $reflector = new ReflectionClass($concrete);
        if(!$reflector->isInstantiable()) {
            echo $message = "Target [$concrete] is not instantiable";
        }

        $constructor = $reflector->getConstructor();
        if(is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();
        $instances = $this->getDependencies($dependencies);

        return $reflector->newInstanceArgs($instances);
    }

    //���ͨ���������ʵ��������ʱ������
    protected function getDependencies($parameters) {
        $dependencies = [];
        foreach($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if(is_null($dependency)) {
                $dependencies[] = NULL;
            } else {
                $dependencies[] = $this->resolveClass($parameter);
            }
        }

        return (array)$dependencies;
    }

    protected function resolveClass(ReflectionParameter $parameter) {
        return $this->make($parameter->getClass()->name);
    }

}