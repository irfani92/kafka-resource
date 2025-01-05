from confluent_kafka import Consumer, KafkaException

# Configuration for the Kafka consumer
config = {
    'bootstrap.servers': 'localhost:9092,localhost:9093,localhost:9094',
    'group.id': 'python_consumer_group',
    'auto.offset.reset': 'earliest'  # Start reading from the beginning of the topic
}

# Create a consumer instance
consumer = Consumer(config)

# Subscribe to the topic
topic = 'myrepublic-kafka'
consumer.subscribe([topic])

try:
    while True:
        msg = consumer.poll(1.0)  # Poll for new messages
        if msg is None:
            continue
        if msg.error():
            if msg.error().code() == KafkaException._PARTITION_EOF:
                # End of partition event
                continue
            else:
                raise KafkaException(msg.error())
        # Display the message
        print(f"Received message: {msg.value().decode('utf-8')} from {msg.topic()} [{msg.partition()}] at offset {msg.offset()}")
except KeyboardInterrupt:
    print("Exiting consumer...")
finally:
    consumer.close()