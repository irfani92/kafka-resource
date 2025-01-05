package main

import (
	"context"
	"encoding/json"
	"fmt"
	"log"

	"github.com/segmentio/kafka-go"
	"gopkg.in/gomail.v2"
)

// Email struct to hold email data
type Email struct {
	To      string `json:"to"`
	Subject string `json:"subject"`
	Body    string `json:"body"`
}

func main() {
	// Producer
	producer := &kafka.Writer{
		Addr:     kafka.TCP("localhost:9092"),
		Topic:    "email-topic",
		Balancer: &kafka.LeastBytes{},
	}

	// Email data
	emailData := Email{
		To:      "irfan.prasetyo@myrepublic.com",
		Subject: "Test Email from Kafka",
		Body:    "This is a test email sent via Kafka.",
	}

	// Encode email data to JSON
	jsonData, err := json.Marshal(emailData)
	if err != nil {
		log.Fatal("Error marshalling email data:", err)
	}

	// Send email data to Kafka
	err = producer.WriteMessages(context.Background(),
		kafka.Message{
			Value: jsonData,
		},
	)
	if err != nil {
		log.Fatal("Failed to write messages: ", err)
	}

	// Close producer
	if err := producer.Close(); err != nil {
		log.Fatal("Failed to close writer: ", err)
	}

	// Consumer
	consumer := kafka.NewReader(kafka.ReaderConfig{
		Brokers:  []string{"localhost:9092"},
		GroupID:  "my-group",
		Topic:    "email-topic",
		MinBytes: 10e3, // 10KB
		MaxBytes: 10e6, // 10MB
	})

	defer consumer.Close()

	for {
		msg, err := consumer.ReadMessage(context.Background())
		if err != nil {
			log.Fatal("error reading message: ", err)
		}

		var email Email
		if err := json.Unmarshal(msg.Value, &email); err != nil {
			log.Fatal("error unmarshalling message: ", err)
		}

		// Send email using gomail
		m := gomail.NewMessage()
		m.SetHeader("From", "noreply@myrepublic.com")
		m.SetHeader("To", email.To)
		m.SetHeader("Subject", email.Subject)
		m.SetBody("text/plain", email.Body)

		d := gomail.NewDialer("localhost", 25, "", "")

		if err := d.DialAndSend(m); err != nil {
			log.Printf("Error sending email: %v", err)
		} else {
			fmt.Printf("Email sent to %s\n", email.To)
		}
	}
}
