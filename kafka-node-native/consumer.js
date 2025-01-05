const kafka = require('kafka-node');

// Configuration for Kafka client and consumer group
const topic = 'myrepublic-kafka';

// Define consumer group options
//https://www.npmjs.com/package/kafka-node
const consumerGroupOptions = {
  kafkaHost: 'localhost:9092',   // Replace with your Kafka brokers if different
  groupId: 'nodejs-consumers',   // Set the consumer group name
  autoCommit: true,
  fetchMaxWaitMs: 1000,
  fetchMaxBytes: 1024 * 1024,
  fromOffset: 'latest'           // Start consuming from the latest offset
};

// Create the ConsumerGroup instance
const consumerGroup = new kafka.ConsumerGroup(consumerGroupOptions, topic);

consumerGroup.on('message', (message) => {
  console.log('Received message:', message);
});

consumerGroup.on('error', (err) => {
  console.error('Consumer error:', err);
});

// Handling offset out-of-range (optional)
consumerGroup.on('offsetOutOfRange', (err) => {
  console.error('Offset out of range:', err);
});
