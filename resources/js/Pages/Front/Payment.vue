<template>
  <Head title="Ticket" />
  <ClientLayout>
    <div
      class="row vh-100 justify-content-center align-items-center position-reactive"
    >
      <div class="col-12 col-sm-6 col-md-6 d-flex justify-content-center">
        <div class="w-50">
          <form @submit.prevent="submit">
            <div class="d-flex gap-3">
              <input
                class="otp"
                v-model="form.one"
                type="text"
                @input="digitValidate"
                @keyup="tabChange(1)"
                maxlength="1"
                placeholder="_"
              />
              <input
                class="otp"
                v-model="form.two"
                type="text"
                @input="digitValidate"
                @keyup="tabChange(2)"
                maxlength="1"
                placeholder="_"
              />
              <input
                class="otp"
                type="text"
                v-model="form.three"
                @input="digitValidate"
                @keyup="tabChange(3)"
                maxlength="1"
                placeholder="_"
              />
              <input
                class="otp"
                type="text"
                v-model="form.four"
                @input="digitValidate"
                @keyup="tabChange(4)"
                maxlength="1"
                placeholder="_"
              />
              <input
                class="otp"
                type="text"
                v-model="form.five"
                @input="digitValidate"
                @keyup="tabChange(5)"
                maxlength="1"
                placeholder="_"
              />
              <input
                class="otp"
                type="text"
                v-model="form.six"
                @input="digitValidate"
                @keyup="tabChange(6)"
                maxlength="1"
                placeholder="_"
              />
            </div>
            <InputError class="mt-2" :message="errors.code" />
          </form>
        </div>
      </div>
      <div class="logo-circle" @click="back"></div>
      <div class="logout-circle">
        <form>
          <Link :href="route('logout')" class="text-dark" method="post">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              style="fill: rgba(0, 0, 0, 1); transform: ; msfilter: "
            >
              <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
              <path
                d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"
              ></path>
            </svg>
          </Link>
        </form>
      </div>
    </div>
  </ClientLayout>
</template>

<script>
import { Link, router, Head } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import InputError from "@/Components/InputError.vue";
import ClientLayout from "@/Components/client/Layout/ClientLayout.vue";

export default {
  components: {
    Link,
    InputError,
    ClientLayout,
    Head,
  },
  setup() {
    const data = reactive({
      code: null,
    });

    const form = reactive({
      one: "",
      two: "",
      three: "",
      four: "",
      five: "",
      six: "",
    });

    let confirm = ref([]);

    let errors = ref({});

    const submit = async () => {
      console.log(form);
      router.post("/payment", data, {
        onError: (err) => {
          errors.value = err;
        },
      });
    };

    const back = () => {
      router.get(route("ready.index"));
    };

    let digitValidate = function (ele) {
      ele.value = ele.value.replace(/[^0-9]/g, "");
      console.log(ele.value);
    };

    let tabChange = function (val) {
      let ele = document.querySelectorAll("input");
      confirm.value.push(ele[val - 1].value);
      if (
        form.one &&
        form.two &&
        form.three &&
        form.four &&
        form.five &&
        form.six
      ) {
        let data = {
          code:
            form.one + form.two + form.three + form.four + form.five + form.six,
        };
        router.post("/payment", data, {
          onError: (err) => {
            errors.value = err;
          },
        });
      }
      if (ele[val - 1].value != "") {
        ele[val].focus();
      } else if (ele[val - 1].value == "") {
        if (ele[val - 2]) {
          ele[val - 2].focus();
        }
      }
    };

    return {
      data,
      errors,
      submit,
      back,
      digitValidate,
      tabChange,
      form,
      confirm,
    };
  },
};
</script>

<style scoped>
form input {
  width: 50px;
  height: 50px;
  text-align: center;
}
.code-box {
  border: 0;
  border-bottom: 0.09em solid black;
  border-radius: 0;
}
.code-box:focus {
  box-shadow: none;
}
</style>
