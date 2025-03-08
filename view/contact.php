<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="./assets/css/contact.css">
</head>

<body>

    <section class="contact" id="contact">
        <div class="container">
            <h2 class="contact-title">Contact Us</h2>

            <div class="contact-form">
                <form id="contact-form">
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subject">Subject</label>
                        <input type="text" class="form-control" name="subject" id="subject">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">Your Message</label>
                        <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Send Message</button>
                </form>

                <p id="responseMessage" class="response-message"></p>
            </div>
        </div>
    </section>

</body>
<script src="./assets/js/contact.js"></script>

</html>