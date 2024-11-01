<template>
  <div class="background">

    <Head title="Contact Us" />

    <div class="container">
      <h1>Contact Us</h1>
      <div class="contact-cards row gap-4 justify-content-center">
        <div class="contact-card">
          <h3>☎</h3>
          <a href="tel:+959788788788">+95 9788788788</a>
        </div>
        <div class="contact-card">
          <h3>✉</h3>
          <a href="mailto:info@example.com">info@example.com</a>
        </div>
        <div class="contact-card">
          <h3>📌</h3>
          <p class="address-text">123 Main Street, Yankin, Yangon</p>
        </div>
        <div class="logo-circle back-logo" @click="back"></div>
      </div>
    </div>

    <footer>
      <p class="footer">
        © 2023
        <a class="footer-link" href="https://geni.technology" target="_blank">
          GENI
        </a>
      </p>
    </footer>
  </div>
</template>

<script setup>
import { Head, router } from "@inertiajs/vue3";

const back = () => {
  router.get(route("front.index"));
}
</script>

<style scoped>
@media screen and (max-width: 769px) {
  .contact-cards {
    display: grid !important;
    padding: 18px;
    margin-bottom: 0;
  }

  .contact-card {
    width: 70vw !important;
  }

  .back-logo {
    position: relative !important;
  }

  .footer {
    position: static !important;
    text-align: center;
  }
}

@media screen and (max-width: 1200px) {
  .contact-cards {
    font-size: 13px;
  }
}

.background {
  min-height: 100vh;
  background: #f9f9f9;
}

.container {
  margin: 0 auto;
  padding: 20px;
}

h1 {
  font-size: 30px;
  margin-top: 30px;
  text-align: center;
  color: #333333;
  margin-bottom: 60px;
}

.contact-card {
  width: 18rem;
  text-align: center;
  flex-basis: calc(33.33% - 20px);
  background-color: #fcfcfc;
  border-radius: 4px;
  padding: 36px;
  margin-bottom: 27px;
  border: 1px solid rgb(214, 214, 214);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.contact-card h3 {
  margin-top: 0;
  margin-bottom: 27px;
  font-size: 27px;
  font-weight: bold;
}

.contact-card a {
  color: black;
  opacity: 75%;
  text-decoration: none;
}

.contact-card a:hover {
  opacity: 100%;
}

.contact-card p {
  margin: 0;
  line-height: 1.5;
}

.address-text {
  opacity: 75%;
}

.footer {
  font-size: 0.8rem;
  position: absolute;
  width: 100%;
  bottom: 0;
  text-align: center;
  margin-bottom: 0;
}

.footer-link {
  color: #0c2242;
  font-weight: bold;
  text-decoration: none;
}
</style>