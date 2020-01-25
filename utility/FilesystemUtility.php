<?php

namespace SecMessage\Utility;

class FilesystemUtility extends \SecMessage\Core\BaseUtility
{

    private $config = null;

    protected function __construct()
    {
        parent::__construct();
        if($this->config == null)
        {
            if(null == ($this->config = \SecMessage\Core\ConfigReader::getConfig('main', 'o')))
            {
                throw new \Exception('Could not read config');
            }
        }
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function createRandomFolder() :?string
    {
        $filespath = __DIR__.'/../'.$this->config->filesystem->folderpath;
        if(!is_writable($filespath))
        {
            return null;
        }

        $cryptUtility   = \SecMessage\Utility\CryptUtility::getInstance();
        $s_new_folder   = $filespath.$cryptUtility->createRandomString(5);
        while(file_exists($s_new_folder) && is_dir($s_new_folder))
        {
            $s_new_folder = $filespath.$cryptUtility->createRandomString(5);
        }

        if(false == mkdir($s_new_folder, 0755))
        {
            return null;
        }
        return $s_new_folder;
    }
}