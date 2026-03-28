<template>
  <v-container :class="containerClass" :fluid="fluid">
    <v-row :align="align" :justify="justify">
      <v-col :cols="cols" :sm="sm" :md="md" :lg="lg" :xl="xl">
        <slot />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  fluid?: boolean
  fillHeight?: boolean
  align?: 'start' | 'center' | 'end' | 'stretch' | 'baseline'
  justify?: 'start' | 'end' | 'center' | 'space-between' | 'space-around' | 'space-evenly'
  cols?: string | number
  sm?: string | number
  md?: string | number
  lg?: string | number
  xl?: string | number
  containerClass?: string
}>(), {
  fluid: true,
  fillHeight: true,
  align: 'center',
  justify: 'center',
  cols: 12,
  sm: 8,
  md: 6,
  lg: 4,
  xl: 4
})

const containerClass = computed(() => {
  const classes = []
  if (props.fillHeight) classes.push('fill-height')
  if (props.containerClass) classes.push(props.containerClass)
  return classes.join(' ')
})
</script>
