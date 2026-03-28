<template>
  <v-dialog 
    :model-value="modelValue" 
    @update:model-value="emit('update:modelValue', $event)"
    v-bind="$attrs"
  >
    <v-card>
      <v-card-title v-if="title" v-bind="titleProps">
        {{ title }}
      </v-card-title>
      <v-card-text v-if="$slots.default">
        <slot />
      </v-card-text>
      <v-card-actions>
        <slot name="actions" />
        <v-spacer v-if="$slots.actions" />
        <v-btn 
          v-if="showClose" 
          text 
          @click="handleClose"
        >
          {{ closeLabel }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script setup lang="ts">
const props = withDefaults(defineProps<{
  title?: string
  titleProps?: Record<string, any>
  closeLabel?: string
  showClose?: boolean
  modelValue?: boolean
}>(), {
  closeLabel: 'Close',
  showClose: true
})

const emit = defineEmits<{
  'update:modelValue': [value: boolean]
}>()

const handleClose = () => {
  emit('update:modelValue', false)
}
</script>
