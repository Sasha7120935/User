<?php

namespace Classes;

class User
{
    const FIlE_NAME = 'file/data.json';

    public function getRows()
    {
        if (file_exists(self::FIlE_NAME)) {
            $jsonData = file_get_contents(self::FIlE_NAME);
            $data = json_decode($jsonData, true);

            if (!empty($data)) {
                usort($data, function ($a, $b) {
                    return $b['id'] - $a['id'];
                });
            }

            return !empty($data) ? $data : false;
        }

        return false;
    }

    public function insert($newData)
    {
        if (!empty($newData)) {
            $id = time();
            $newData['id'] = $id;

            $jsonData = file_get_contents(self::FIlE_NAME);
            $data = json_decode($jsonData, true);

            $data = !empty($data) ? array_filter($data) : $data;
            if (!empty($data)) {
                array_push($data, $newData);
            } else {
                $data[] = $newData;
            }
            $insert = file_put_contents(self::FIlE_NAME, json_encode($data));

            return $insert ? $id : false;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $jsonData = file_get_contents(self::FIlE_NAME);
        $data = json_decode($jsonData, true);

        $newData = array_filter($data, function ($var) use ($id) {
            return ($var['id'] != $id);
        });
        $delete = file_put_contents(self::FIlE_NAME, json_encode($newData));
        return (bool)$delete;
    }
}