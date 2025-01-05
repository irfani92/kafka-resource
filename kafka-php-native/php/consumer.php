<?php

$conf = new RdKafka\Conf();
$conf->set('group.id', 'php-consumer-group');
$conf->set('metadata.broker.list', 'broker:29092');
$conf->set('auto.offset.reset', 'earliest');


$topicName = 'php-topic';

// Create a Kafka consumer
$consumer = new RdKafka\KafkaConsumer($conf);

// Subscribe to the topic
$consumer->subscribe([$topicName]);

echo "Waiting for messages on topic: $topicName\n";

// Consume messages
while (true) {
    $message = $consumer->consume(120 * 1000);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            echo "Received message: " . $message->payload . "\n";
            break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            echo "End of partition reached\n";
            break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            echo "Timed out\n";
            break;
        default:
            echo $message->errstr() . "\n";
            break;
    }
}
