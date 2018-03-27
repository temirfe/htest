<?php

namespace app\models;

use Yii;
use yii\elasticsearch\ActiveRecord as ElasticActiveRecord;

/**
 * This is the model class for table "Page".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $date
 */
class PageElastic extends ElasticActiveRecord
{
    public static function index(){
        return "yoba";
    }

    public static function type(){
        return "nigga";
    }
    public function attributes()
    {

        return['id', 'title', 'text','date'];

    }
    /**
     * @return array This model's mapping
     */
    public static function mapping()
    {
        return [
            static::type() => [
                'properties' => [
                    'id' => ['type' => 'long'],
                    'title' => ['type' => 'text'],
                    'text' => ['type' => 'text'],
                    'date' => ['type' => 'date'],
                ]
            ],
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Create this model's index
     */
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        if(!$command->indexExists(self::index())){
            $command->createIndex(static::index(), [
                //'settings' => [ /* ... */ ],
                'mappings' => static::mapping(),
                //'warmers' => [ /* ... */ ],
                //'aliases' => [ /* ... */ ],
                //'creation_date' => '...'
            ]);
        }
    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index(), static::type());
    }
    
    public static function updateRecord($book_id, $columns){
        try{
            $record = self::get($book_id);
            foreach($columns as $key => $value){
                $record->$key = $value;
            }

            return $record->update();
        }
        catch(\Exception $e){
            //handle error here
            return false;
        }
    }

    public static function deleteRecord($book_id)
    {
        try{
            $record = self::get($book_id);
            $record->delete();
            return 1;
        }
        catch(\Exception $e){
            //handle error here
            return false;
        }
    }

    public static function addRecord($book){
        $isExist = false;

        try{
            $record = self::get($book->id);
            if(!$record){
                $record = new self();
                $record->setPrimaryKey($book->id);
            }
            else{
                $isExist = true;
            }
        }
        catch(\Exception $e){
            $record = new self();
            $record->setPrimaryKey($book->id);
        }

        $suppliers = [
            ['id' => '1', 'name' => 'ABC'],
            ['id' => '2', 'name' => 'XYZ'],
        ];

        $record->id   = $book->id;
        $record->name = $book->name;
        $record->status = 1;
        $record->suppliers = $suppliers;

        try{
            if(!$isExist){
                $result = $record->insert();
            }
            else{
                $result = $record->update();
            }
        }
        catch(\Exception $e){
            $result = false;
            //handle error here
        }

        return $result;
    }
}
