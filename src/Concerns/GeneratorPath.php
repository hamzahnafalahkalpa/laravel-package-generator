<?php

namespace Hanafalah\LaravelPackageGenerator\Concerns;

trait GeneratorPath{
    /**
     * Get the path to the stub for the class.
     *
     * @return string The path to the stub.
     */
    protected function getClassStubPath(): string{
        return $this->getBaseStub().'/class.stub';
    }

    /**
     * Get the path to the stub for the composer.json.
     *
     * @return string The path to the stub.
     */
    protected function getComposerStubPath(): string{
        return $this->getBaseStub().'/composer.json.stub';
    }


    protected function getComposerRequireStubPath(): string{
        return $this->getBaseStub().'/composer-require.stub';
    }

    protected function getComposerRepoStubPath(): string{
        return $this->getBaseStub().'/composer-repo.stub';
    }

    /**
     * Get the path to the stub for the config.
     *
     * @return string The path to the stub.
     */
    protected function getConfigStubPath(): string{
        return $this->getBaseStub().'/config.stub';
    }

    /**
     * Get the path to the stub for the provider command.
     *
     * @return string The path to the stub.
     */
    protected function getProviderCommandStubPath(): string{
        return $this->getBaseStub().'/provider-command.stub';
    }

    /**
     * Get the path to the stub for the provider route.
     *
     * @return string The path to the stub.
     */
    protected function getProviderRouteStubPath(): string{
        return $this->getBaseStub().'/provider-route.stub';
    }

    protected function getIgnoreStubPath(): string{
        return $this->getBaseStub().'/.gitignore.stub';
    }

    /**
     * Get the path to the stub for the web.
     *
     * @return string The path to the stub.
     */
    protected function getWebStubPath(): string{
        return $this->getBaseStub().'/web.stub';
    }

    /**
     * Get the path to the stub for the api.
     *
     * @return string The path to the stub.
     */
    protected function getApiStubPath(): string{
        return $this->getBaseStub().'/api.stub';
    }

    /**
     * Get the path to the stub for the support file repository.
     *
     * @return string The path to the stub.
     */
    protected function getSupportFileRepoStubPath(): string{
        return $this->getBaseStub().'/support-file-repository.stub';
    }

    /**
     * Get the path to the stub for the class local paths.
     *
     * @return string The path to the stub.
     */
    protected function getClassLocalStubPath(): string{
        return $this->getBaseStub().'/class-local-paths.stub';
    }

    /**
     * Get the path to the stub for the add installation schema.
     *
     * @return string The path to the stub.
     */
    protected function getAddInstallationSchemaStubPath(): string{
        return $this->getBaseStub().'/add-installation-schema.stub';
    }

    /**
     * Get the path to the stub for the facade class.
     *
     * @return string The path to the stub.
     */
    protected function getFacadeStubPath(): string{
        return $this->getBaseStub().'/facade-class.stub';
    }

    /**
     * Get the path to the stub for the provider class that contains the environment code.
     *
     * @return string The path to the stub.
     */
    protected function getProviderEnvStubPath(): string{
        return $this->getBaseStub().'/provider-environment.stub';
    }

    /**
     * Get the path to the stub for the interface file repository.
     *
     * @return string The path to the stub.
     */
    protected function getInterfaceFileRepoStubPath(): string{
        return $this->getBaseStub().'/interface-file-repository.stub';
    }

    /**
     * Get the path to the stub for the model schema.
     *
     * @return string The path to the stub.
     */
    protected function getModelSchemaStubPath(): string{
        return $this->getBaseStub().'/add-model-schema.stub';
    }

    /**
     * Get the path to the stub for the schema.
     *
     * @return string The path to the stub.
     */
    protected function getSchemaStubPath(): string{
        return $this->getBaseStub().'/add-schema.stub';
    }

    /**
     * Get the path to the stub for the installation schema.
     *
     * @return string The path to the stub.
     */
    protected function getInstallationSchemaStubPath(): string{
        return $this->getBaseStub().'/add-installation-schema.stub';
    }
}
