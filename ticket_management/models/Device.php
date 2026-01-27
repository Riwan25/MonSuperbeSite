<?php
class Device {
    private int $id;
    private string $externalUid;
    private int $deviceTypeId;

    public function __construct($externalUid, $deviceTypeId, $id) { 
        $this->id = $id;
        $this->externalUid = $externalUid;
        $this->deviceTypeId = $deviceTypeId;
    }
    public function getId(){
        return $this->id;
    }
    public function getExternalUid(){
        return $this->externalUid;
    }
    public function getDeviceTypeId(){
        return $this->deviceTypeId;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setExternalUid($externalUid){
        $this->externalUid = $externalUid;
    }
    public function setDeviceTypeId($deviceTypeId){
        $this->deviceTypeId = $deviceTypeId;
    }


}