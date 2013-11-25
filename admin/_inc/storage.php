<?php
require 'vendor/autoload.php';
use Aws\Common\Aws;
use Aws\S3\Exception\S3Exception;

class S3Storage
{
    protected $client;
    protected $bucket;

    public function __construct()
    {
        $this->client = Aws::factory(array(
            'key'    => 'AKIAILJSS2HVKOE7PHAA',
            'secret' => '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',
        ))->get('s3');
    }

    public function bucket($bucket)
    {
        // if (!$this->client->doesBucketExist($bucket)) { #nao funciona?
        $result = $this->client->listBuckets();
        if (!in_array($bucket, $result['Buckets'])) {
            $this->client->createBucket(array('Bucket' => $bucket));
        }

        $this->setBucket($bucket);

        return $this;
    }

    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
    }

    public function put($file, $key = '', $args=array())
    {
        //apaga arquivo se já existir
        if ($this->client->doesObjectExist($this->bucket, $file['name']))
            $this->client->deleteObject(array('Bucket' => $this->bucket, 'Key' => $file['name']));

        $path = null;
        if (isset($args['path']))
            $path = $args['path'];

        try {

            return $this->client->putObject(
                array(
                    'Bucket' => $this->bucket,
                    'Key'    => $path.$file['name'],
                    'Body'   => fopen($file['tmp_name'], 'r+'),
                    'ACL'    => 'public-read'
                )
            );

        } catch (S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
    }

    public function drop($name)
    {
        //apaga arquivo se já existir
        if (!$this->client->doesObjectExist($this->bucket, $name))
            return false;

        try {
            $this->client->deleteObject(array('Bucket' => $this->bucket, 'Key' => $name));
            return true;
        } catch (S3Exception $e) {
            return "There was an error removing the file.\n";
        }
    }

}