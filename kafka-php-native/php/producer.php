<?php

$conf = new RdKafka\Conf();

// Set the producer ID
$conf->set('client.id', 'php-producer');
$conf->set('metadata.broker.list', 'broker:29092');

$topicName = 'php-topic';

// Create a producer
$producer = new RdKafka\Producer($conf);
$topic = $producer->newTopic($topicName);

// Produce messages to Kafka
for ($i = 0; $i < 10; $i++) {
    $message = "Message $i at " . date('Y-m-d H:i:s');
    echo "Producing message: $message\n";
    
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
    $producer->poll(0);
}

// Flush producer to ensure messages are sent
$producer->flush(1000);
echo "Producer finished.\n";
