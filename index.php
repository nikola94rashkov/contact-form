<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    
    <title>Document</title>
</head>
<body>
    <!-- Please create a standard contact form that sends an email message after 
        submission using Ajax and PHP. 
        The form needs to include these 
        fields: Name, Phone, Email, Message. 
        Please consider everything that needs to be done for a production-ready contact form. -->
    <div class="loader">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>

    <section class="section">
        <div class="shell">
            <div class="section__form">
                <form class="form" id="contact-form">
                    <div class="form__title">
                        <h1 id="title">Send Message</h1>
                    </div>

                    <div class="form__body">
                        <div class="form__row">
                            <label for="name">Add your Name</label>

                            <div class="form__field">
                                <input id="name" name="name" type="text">
                            </div>
                        </div>

                        <div class="form__row">
                            <label for="phone">Add your Phone</label>

                            <div class="form__field">
                                <input id="phone" name="phone" type="tel">
                            </div>
                        </div>

                        <div class="form__row">
                            <label for="email">Add your Email</label>

                            <div class="form__field">
                                <input id="email" name="email" type="email">
                            </div>
                        </div>

                        <div class="form__row">
                            <label for="message">Add your Message</label>

                            <div class="form__field">
                                <textarea id="message" name="message"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form__actions">
                        <button type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script type="module" src="scripts/index.js"></script>
</body>
</html>
