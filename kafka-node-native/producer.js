const kafka = require('kafka-node');

// Create a client and producer
const client = new kafka.KafkaClient({ kafkaHost: 'localhost:9092' });
const producer = new kafka.Producer(client);

// Initialize a counter
let counter = 1;

// When the producer is ready, start sending messages every 5 seconds
producer.on('ready', () => {
  console.log('Producer is ready');

  // Set an interval to send messages every 5 seconds
  setInterval(() => {
    const payloads = [
      { topic: 'myrepublic-kafka', messages: `Message ${counter} from Node.js` },
    ];

    producer.send(payloads, (err, data) => {
      if (err) {
        console.error('Error sending message:', err);
      } else {
        console.log(`Message ${counter} sent successfully:`, data);
      }

      // Increment the counter for the next message
      counter += 1;
    });
  }, 3000); // 5 seconds
});

// Handle errors
producer.on('error', (err) => {
  console.error('Producer error:', err);
});
