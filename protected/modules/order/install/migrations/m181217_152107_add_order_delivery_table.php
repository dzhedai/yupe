<?php

class m181217_152107_add_order_delivery_table extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_order_delivery}}",
            [
                "id" => "pk",
                "order_id" => "integer not null",
                "delivery_id" => "integer null",
                "delivery_name" => "varchar(255) not null",
                "delivery_details"=>"varchar(1024) null",
                "delivery_price" => "decimal(10, 2) not null default '0'",
                "separate_delivery" => "tinyint null default '0'",
                "zipcode" => "integer null",
                "country" => "integer null",
                "city" => "integer null",
                "street" => "integer null",
                "house" => "integer null",
                "apartment" => "integer null",
                "paid"=>"tinyint null default '0'"
            ],

            $this->getOptions()
        );

        $this->createIndex("idx_{{store_order_delivery}}_order_id", "{{store_order_delivery}}", "order_id");
        $this->createIndex("idx_{{store_order_delivery}}_delivery_id", "{{store_order_delivery}}", "delivery_id");

        $this->addForeignKey("fk_{{store_order_delivery}}_order", "{{store_order_delivery}}", "order_id", "{{store_order}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{store_order_delivery}}_delivery", "{{store_order_delivery}}", "delivery_id", "{{store_delivery}}", "id", "SET NULL", "CASCADE");



    }

    public function safeDown()
    {
        $this->dropTable("{{store_order_delivery}}");
    }
}