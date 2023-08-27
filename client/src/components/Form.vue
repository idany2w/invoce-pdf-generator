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
						v-model:files="form.logo"
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
          />
        </div>
        <div class="form__item">
          <InputText
            label="KPP"
            labelClass="form__label"
            name="supplier.kpp"
            placeholder="supplier.kpp"
            v-model="form.supplier.kpp"
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

      <div class="form__item">
        <button class="form__submit-btn btn" @click="submit">Submit</button>
      </div>
    </div>
  </div>
</template>

<script>
import InputText from "./InputText.vue";
import InputTable from "./InputTable.vue";
import InputFile from "./InputFile.vue";
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
      form: {
				logo: null,
        supplier: {
          name: null,
          inn: null,
          kpp: null,
        },
        client: {
          fullName: null,
          inn: null,
        },
        products: [],
      },
    };
  },

  methods: {
    productsColInput(value, colIndex, rowIndex) {
      value = value?.trim();

      if (["quantity", "price"].includes(colIndex)) {
        let parts = value.replace(/[^\d\.]+/, "").split(".");

        value = parts[0];

        if (parts[1] === "" || parseInt(parts[1])) {
          value = `${value}.${parts[1]}`;
        }
      }

      this.form.products[rowIndex][colIndex] = `${value}`;
    },

    makeFormData(object) {
      let formData = new FormData();

			formData.append('supplier', JSON.stringify(object.supplier))
			formData.append('client', JSON.stringify(object.client))
			formData.append('products', JSON.stringify(object.products))
			formData.append('logo', object.logo[0])

      return formData;
    },

    async submit() {
      if (this.pendings.form) return;

      this.pendings.form = true;
      this.errors.form = {};

      let formData = this.makeFormData(this.form);
			
			

    },
  },
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