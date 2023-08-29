<template>
  <div
    class="form"
    :class="{
      'form--pending': pendings.form,
    }"
  >
    <p class="form__title">Invoce PDF Form</p>
    <div class="form__content">
      <div class="form__item form__group form__content">
        <p class="form__label">Supplier</p>
        <div class="form__item">
          <p class="form__label">Logo</p>
          <InputFile
						class="form__input"
						v-model:files="form.supplier.logo"
					/>
        </div>
        <div class="form__item">
          <InputText
            label="Name"
            labelClass="form__label"
            name="supplier.name"
            placeholder="supplier.name"
            v-model="form.supplier.name"
          />
        </div>
        <div class="form__item">
          <InputText
            label="INN"
            labelClass="form__label"
            name="supplier.inn"
            placeholder="supplier.inn"
            v-model="form.supplier.inn"
            @input="numericInput"
          />
        </div>
        <div class="form__item">
          <InputText
            label="KPP"
            labelClass="form__label"
            name="supplier.kpp"
            placeholder="supplier.kpp"
            v-model="form.supplier.kpp"
            @input="numericInput"
          />
        </div>
        <div class="form__item">
          <InputText
            label="Address"
            labelClass="form__label"
            name="supplier.address"
            placeholder="supplier.address"
            v-model="form.supplier.address"
          />
        </div>
      </div>

      <div class="form__item form__group form__content">
        <p class="form__label">Client</p>
        <div class="form__item">
          <InputText
            label="Full Name"
            labelClass="form__label"
            name="supplier.fullName"
            placeholder="supplier.fullName"
            v-model="form.client.fullName"
          />
        </div>
        <div class="form__item">
          <InputText
            label="INN"
            labelClass="form__label"
            name="supplier.inn"
            placeholder="supplier.inn"
            v-model="form.client.inn"
            @input="numericInput"
          />
        </div>
        <div class="form__item">
          <InputText
            label="Address"
            labelClass="form__label"
            name="client.address"
            placeholder="client.address"
            v-model="form.client.address"
          />
        </div>
      </div>

      <div class="form__item form__group form__content">
        <p class="form__group-label form__label">Products</p>
        <div class="form__item">
          <InputTable
            name="products"
            v-model:rows="form.products"
            @input="productsColInput"
            :colTemplate="{
              name: null,
              quantity: null,
              price: null,
            }"
          />
        </div>
      </div>

      <div class="form__item form__errors" v-if="errors.form?.message || formErrors.length">
        <p v-if="errors.form?.message" class="form__errors-title">{{ errors.form?.message }}</p>

        <template v-if="formErrors.length">
          <p
            class="form__error"
            v-for="(errorMessage, key) in formErrors"
            :key="key"
          >
            {{ errorMessage }}
          </p>
        </template>
      </div>

      <div class="form__item">
        <button class="form__submit-btn btn" @click="submit">Submit</button>
      </div>
    </div>
  </div>
</template>

<script>
import InputText from "@/components/InputText.vue";
import InputTable from "@/components/InputTable.vue";
import InputFile from "@/components/InputFile.vue";
import { parseNumeric } from "@/utils/helpers"
import axios from "axios";
export default {
  name: "Form",
  components: {
    InputText,
    InputTable,
    InputFile,
  },
  data() {
    return {
      pendings: {},
      errors: {},
      form: {},
    };
  },

  computed:{
    formErrors(){
      if(!this.errors.form?.errors){
        return [];
      }

      let result = [];

      for (const key in this.errors.form.errors) {
        result.push(...this.errors.form.errors[key]);
      }

      return result;
    }
  },

  methods: {
    resetForm(){
      this.form = {
        supplier: {
          logo: null,
          name: null,
          inn: null,
          kpp: null,
          address: null,
        },
        client: {
          fullName: null,
          inn: null,
          address: null,
        },
        products: [],
      }
    },

    numericInput(event){
      event.target.value = parseNumeric(event.target.value);
    },
    productsColInput(value, colIndex, rowIndex) {
      value = value?.trim();

      if (["quantity", "price"].includes(colIndex)) {
        value = parseNumeric(value);
      }

      this.form.products[rowIndex][colIndex] = `${value}`;
    },

    async submit() {
      if (this.pendings.form) return;

      this.pendings.form = true;
      this.errors.form = {};

      try {
        let response = await axios.postForm(
          `${process.env.VUE_APP_API_URL}/api/generate-invoce-pdf`,
          this.form,
          {
            responseType: 'blob',
            validateStatus: (s) => s === 200,
          }
        );

        const href = URL.createObjectURL(response.data);
        const link = document.createElement('a');
        link.href = href;
        link.setAttribute('download', 'file.pdf'); //or any other extension
        document.body.appendChild(link);
        link.click();

        document.body.removeChild(link);
        URL.revokeObjectURL(href);

        this.resetForm();
      } catch (error) {
        console.error(error)
        let errorResponse = await error.response.data.text();

        this.errors.form = JSON.parse(errorResponse);
      } finally {
        this.pendings.form = false;
      }
    },
  },

  created(){
    this.resetForm();
  }
};
</script>


<style lang="scss">
.form {
  transition: opacity 0.25s;
  padding: 20px 10px;
  background-color: var(--color-3);
  border-radius: 10px;
  color: var(--color-1);

  &__title {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
  }

  &__content {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    max-width: 768px;
    margin: 0 auto;
  }

  &__group {
    width: 100%;
  }

  &__item {
    width: 100%;
  }

  &__label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
  }
  
  &__errors{
    padding: 1em;
    border: var(--color-2) 1px solid;
    &-title{
      color: var(--color-2);
      margin-bottom: 1em;
    }
  }

  &__error{
    color: var(--color-2)
  }

  &__submit-btn {
    background: var(--color-1);
    color: var(--color-3);
  }

  &--pending {
    opacity: 0.5;
    pointer-events: none;
  }
}
</style>