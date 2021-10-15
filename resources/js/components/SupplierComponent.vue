<template>
<div>
 <v-date-picker
  :value="range"
  color="purple"
  is-dark
  is-range
  />
</div>
</template>

<script>
export default {
    data() {
        return {
            range: {
                start: new Date(2020, 0, 1),
                end: new Date(2020, 0, 5)
            }
        };
    }
};
</script>

<style></style>
