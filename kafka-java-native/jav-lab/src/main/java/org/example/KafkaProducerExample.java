package org.example;

import org.apache.kafka.clients.producer.KafkaProducer;
import org.apache.kafka.clients.producer.ProducerConfig;
import org.apache.kafka.clients.producer.ProducerRecord;
import org.apache.kafka.common.serialization.StringSerializer;

import java.util.Properties;

public class KafkaProducerExample {
    public static void main(String[] args) {

        // Kafka configuration properties
        Properties props = new Properties();
        props.put(ProducerConfig.BOOTSTRAP_SERVERS_CONFIG, "localhost:9092"); // Adjust if different
        props.put(ProducerConfig.KEY_SERIALIZER_CLASS_CONFIG, StringSerializer.class.getName());
        props.put(ProducerConfig.VALUE_SERIALIZER_CLASS_CONFIG, StringSerializer.class.getName());

        // Create Kafka producer
        KafkaProducer<String, String> producer = new KafkaProducer<>(props);

        // Send messages
        for (int i = 0; i < 10; i++) {
            String key = "key-" + i;
            String value = "value-" + i;

            ProducerRecord<String, String> record = new ProducerRecord<>("myrepublic-kafka", key, value);
            producer.send(record, (metadata, exception) -> {
                if (exception == null) {
                    System.out.println("Sent message: " + key + " | " + value);
                } else {
                    exception.printStackTrace();
                }
            });
        }

        // Close the producer
        producer.close();
    }
}
