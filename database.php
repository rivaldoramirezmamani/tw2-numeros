<?php

class Database {
    private $file;
    private $data;

    public function __construct($file = 'database.json') {
        $this->file = $file;
        $this->load();
    }

    private function load() {
        if (file_exists($this->file)) {
            $content = file_get_contents($this->file);
            $this->data = json_decode($content, true) ?? [];
        } else {
            $this->data = [];
        }
    }

    private function save() {
        file_put_contents($this->file, json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function getAll() {
        return $this->data;
    }

    public function getById($id) {
        foreach ($this->data as $user) {
            if ($user['id'] === $id) {
                return $user;
            }
        }
        return null;
    }

    public function create($user) {
        $user['id'] = $this->generateId();
        $this->data[] = $user;
        $this->save();
        return $user;
    }

    public function update($id, $user) {
        foreach ($this->data as &$u) {
            if ($u['id'] === $id) {
                $u = array_merge($u, $user);
                $u['id'] = $id;
                $this->save();
                return $u;
            }
        }
        return null;
    }

    public function delete($id) {
        foreach ($this->data as $key => $user) {
            if ($user['id'] === $id) {
                unset($this->data[$key]);
                $this->data = array_values($this->data);
                $this->save();
                return true;
            }
        }
        return false;
    }

    private function generateId() {
        return time() . '_' . rand(1000, 9999);
    }
}
