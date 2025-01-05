from confluent_kafka import Producer

# Configuration for the Kafka producer
config = {
    'bootstrap.servers': 'localhost:9092,localhost:9093,localhost:9094'  # Assuming Kafka is running locally
}

# Create a producer instance
producer = Producer(config)

# Define a callback to handle the result of message delivery
def delivery_report(err, msg):
    if err is not None:
        print(f"Message delivery failed: {err}")
    else:
        print(f"Message delivered to {msg.topic()} [{msg.partition()}]")

# Produce messages to the topic
topic = 'myrepublic-kafka'
try:
    while True:
        message = input("Enter message to produce (Ctrl+C to exit): ")
        producer.produce(topic, message.encode('utf-8'), callback=delivery_report)
        producer.poll(0)  # Poll to handle delivery callbacks
except KeyboardInterrupt:
    print("Exiting producer...")
finally:
    producer.flush() 