<template>
  <router-view/>
</template>

<style lang="scss">

:root{
  --color-1: #2c3e50;
  --color-2: red;
  --color-3: white;
  --color-4: #f3f3f3;
}


*{
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  color: var(--color-2);
  background-color: var(--color-1);
  padding: 20px;
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow-y: auto;
  overflow-x: hidden;
}

button{
  cursor: pointer;
  background-color: transparent;
  border-color: transparent;
  border-style: solid;
  border-width: 0px;
  outline: none;
  appearance: none;
}

.btn{
  display: inline-flex;
  font-size: 14px;
  font-weight: bold;
  padding: .6em 1em;
  border-radius: .2em;
}

.container{
  max-width: 768px;
  margin: auto;
}
</style>
