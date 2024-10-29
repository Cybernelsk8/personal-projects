<?php

namespace Core\Session;

class Session {

    protected SessionDrive $drive;

    public const FLASH_KEY = '_flash';

    public function __construct(SessionDrive $drive) {
        $this->drive = $drive;
        $this->drive->start();

        if(!$this->drive->has(self::FLASH_KEY)){
            $this->drive->set(self::FLASH_KEY,['old'=>[],'new' => []]);
        }
    }

    public function __destruct(){
        foreach ($this->drive->get(self::FLASH_KEY)['old'] as $key) {
            $this->drive->remove($key);
        }
        $this->ageFlashData();
        $this->drive->save();
    }

    public function ageFlashData() {
        $flash = $this->drive->get(self::FLASH_KEY);
        $flash['old'] = $flash['new'];
        $flash['new'] = [];
        $this->drive->set(self::FLASH_KEY,$flash);
    }

    public function flash(string $key, mixed $value) {
        $this->drive->set($key,$value);
        $flash = $this->drive->get(self::FLASH_KEY);
        $flash['new'][] = $key;
        $this->drive->set(self::FLASH_KEY,$flash); 
    }

    public function id() : string {
        return $this->drive->id();
    }

    public function get(string $key, mixed $default = null) {
        return $this->drive->get($key,$default);
    }

    public function set(string $key, mixed $value) {
        return $this->drive->set($key,$value);
    }

    public function has(string $key) : bool {
        return $this->drive->has($key);
    }

    public function remove(string $key) {
        return $this->drive->remove($key);
    }

    public function destroy() {
        return $this->drive->destroy();
    }
}