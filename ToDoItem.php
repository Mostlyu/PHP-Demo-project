<?php

require_once 'JsonDataStore.php';

class ToDoItem {

    public int $id;
    public string $created_at;
    public string $title;
    public string $due_date;
    public string $description;
    public ToDoItemStatus $status;

  //TODO now() for created_at
      private static function now(): string {
          return date('Y-m-d H:i:s');
      }

    public function __construct(
        string $title,
        string $due_date,
        string $description,
        ToDoItemStatus $status) {

        $this->title = $title;
        $this->due_date = $due_date;
        $this->description = $description;
        $this->status = $status;
        $this->created_at  = self::now();
    }

    public static function fromArray(array $data): ToDoItem {
        $item = new ToDoItem(
            $data['title'],
            $data['due_date'],
            $data['description'],
            ToDoItemStatus::from($data['status'])
        );
        $item->created_at = $data['created_at'];
        $item->id = $data['id'];
        return $item;
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'created_at'  => $this->created_at,
            'title'       => $this->title,
            'description' => $this->description,
            'due_date'    => $this->due_date,
            'status'      => $this->status->value,
        ];
    }

}




