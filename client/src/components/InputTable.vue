<template>
  <div class="input-table">
    <div class="input-table__rows">
      <div
        class="input-table__row"
        v-for="(row, rowIndex) in rows"
        :key="rowIndex"
      >
        <div class="input-table__col input-table__col--number">
          <p>{{ 1 + rowIndex }}</p>
        </div>
        <div
          class="input-table__col"
          v-for="(col, colKey) in row"
          :key="colKey"
        >
					<InputText
						type="text"
						v-model="rows[rowIndex][colKey]"
						@input="$emit('input', rows[rowIndex][colKey], colKey, rowIndex)"
						:name="`${name}.${rowIndex}.${colKey}`"
						:placeholder="`${name}.${colKey}`"
					/>
        </div>

        <div class="input-table__col">
          <button
            class="input-table__remove-btn btn"
            @click="deleteRow(rowIndex)"
          >
            Del
          </button>
        </div>
      </div>
    </div>

    <button
			class="input-table__add-row-btn btn"
			@click="addRow"
		>
			Add
		</button>
  </div>
</template>

<script>
import InputText from './InputText.vue';
export default {
	name: 'InputTable',
	components:{
		InputText
	},
	props:{
    rows: Array,
		name: {
			required: true
		},
		colTemplate: {
			required: true
		}
	},
	emits: [
		'update:rows',
		'input'
	],
	methods: {
		addRow(){
			this.rows.push(Object.assign({}, this.colTemplate));
			this.$emit('update:rows', this.rows);
		},
		deleteRow(index){
			this.rows.splice(index, 1);
			this.$emit('update:rows', this.rows);
		},
	},
};
</script>

<style lang="scss">
.input-table {
  width: 100%;
  overflow-x: auto;

  &__rows {
    display: table;
    min-width: 100%;

    &:not(:empty) {
      width: 500px;
    }
  }

  &__row {
    display: table-row;
  }

  &__col {
    display: table-cell;

    &--number {
      font-weight: bold;
      text-align: center;
      padding: 0 8px;
    }
  }

  &__remove-btn {
    background-color: var(--color-2);
    color: var(--color-3);
  }

  &__add-row-btn {
    margin-top: 8px;
    background-color: var(--color-1);
    color: var(--color-3);
    position: sticky;
    left: 0;
  }
}
</style>