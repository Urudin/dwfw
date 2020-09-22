<?php


namespace Different\Dwfw\app\Traits;


use Illuminate\Support\Arr;
use Exception;

trait DwfwTestCase
{
    protected function it_should_have_required_fields($api_url, $required_fields, $api_data)
    {
        foreach ($required_fields as $required_field) {
            if (!isset($api_data[$required_field])) {
                throw new Exception('Unset required field in api data');
            }
            $response = $this
                ->postJson($api_url, Arr::except($api_data, [$required_field]))
                ->decodeResponseJson();
            $this->assertTrue($response['error']);
            $this->assertArrayHasKey($required_field, $response['message']);
        }
    }

    protected function assertResponseForError($response, string $property): void
    {
        $this->assertTrue($response['error']);
        $this->assertArrayHasKey($property, $response['message']);
    }


}