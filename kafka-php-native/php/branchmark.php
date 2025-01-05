<?php
// Kafka Config
$conf = new RdKafka\Conf();
$conf->set('bootstrap.servers', 'broker:29092');
$conf->set('client.id', 'php-producer');
$conf->set('batch.size', 1024);
$conf->set('linger.ms', 5);
$conf->set('compression.type', 'snappy');
$producer = new RdKafka\Producer($conf);
$topic = $producer->newTopic('my_topic');

// Send message to kafka 
function sendToKafkaBatch($data) {
    global $producer, $topic;
    $messages = [];
    foreach ($data as $item) {
        $messages[] = RD_KAFKA_RESP_ERR_NO_ERROR;
        $topic->producev(RD_KAFKA_PARTITION_UA, 0, $item, $messages[count($messages) - 1]);
    }
    $producer->flush(1000);
}

function processDataManually($data) {
    // Data processing simulation
    foreach ($data as $item) {
       
    }
}

// Generate data
$data = range(1, 1000);

// Send datas into kafa
$startTime = microtime(true);
sendToKafkaBatch($data);
$endTime = microtime(true);
echo "Kafka send time (batch): " . ($endTime - $startTime) . " second\n";


$startTime = microtime(true);
processDataManually($data);
$endTime = microtime(true);
echo "Manual send time: " . ($endTime - $startTime) . " second\n";