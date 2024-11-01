<template>
  <Head title="Log in" />
  <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
    {{ status }}
  </div>
  <div class="container-fluid">
    <div class="row justify-content-center vh-100 align-items-center">
      <div class="col-12 col-md-4">
          <div class="px-2 py-5 rounded shadow">
            <div
              class="
                d-flex
                justify-content-center
                align-items-center
                flex-column
              "
            >
              <img
                src="/images/logo2.png"
                alt=""
                class="login-img"
              />
              <div class="mb-3">
                <h2 class="fw-bold text-uppercase mb-0">Login</h2>
              </div>
            </div>
            <form class="px-4" @submit.prevent="submit">
              <div class="mb-4">
                <input type="email" 
                    v-model="form.email"
                    required
                    autofocus
                    class="form-control" 
                    placeholder="example@gmail.com" />
                <InputError class="mt-2" :message="form.errors.email" />
              </div>
              <div class="mb-4">
                <input
                  type="password"
                  v-model="form.password"
                  required
                  class="form-control"
                  placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
              </div>
              <div class="mb-4 d-flex justify-content-between">
                <div class="form-check">
                 <Checkbox name="remember" id="check-me" v-model:checked="form.remember" />
                  <span for="check-me">Remember me</span>
                </div>
                <div>
                  <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Forgot your password?
                    </Link>
                </div>
              </div>
              <div class="d-flex justify-content-center">
                <button class="btn btn-outline-primary w-50">LOGIN</button>
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<style scoped>
.login-img {
  width: 160px;
  height: 160px;
  object-fit: cover;
  object-position: contain;
  display: block;
}
</style>