<template>
  <v-dialog 
    :model-value="modelValue" 
    @update:model-value="handleDialogChange"
    :aria-labelledby="headingId"
    :aria-describedby="contentId"
    :aria-modal="true"
    v-bind="$attrs"
  >
    <v-card rounded="lg">
      <!-- Dialog heading - associated with aria-labelledby -->
      <v-card-title 
        v-if="title" 
        :id="headingId"
        v-bind="titleProps"
      >
        {{ title }}
      </v-card-title>

      <!-- Dialog content - associated with aria-describedby -->
      <v-card-text 
        v-if="$slots.default"
        :id="contentId"
      >
        <slot />
      </v-card-text>

      <!-- Dialog actions -->
      <v-card-actions>
        <slot name="actions" />
        <v-spacer v-if="$slots.actions" />
        <AppButton
          v-if="showClose"
          type="button"
          variant="text"
          :aria-label="`${closeLabel} (Escape key)`"
          @click="handleClose"
          @keydown.escape="handleClose"
        >
          {{ closeLabel }}
        </AppButton>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { useAccessibility } from '~/composables/useAccessibility'

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

const { saveFocusAndShift, restoreFocus } = useAccessibility()

// Generate unique IDs for ARIA associations
const headingId = `dialog-heading-${Math.random().toString(36).substr(2, 9)}`
const contentId = `dialog-content-${Math.random().toString(36).substr(2, 9)}`

const handleDialogChange = async (isOpen: boolean) => {
  if (isOpen) {
    // Save focus before opening dialog
    await saveFocusAndShift(null)
  } else {
    // Restore focus when dialog closes
    restoreFocus()
  }
  emit('update:modelValue', isOpen)
}

const handleClose = () => {
  emit('update:modelValue', false)
}
</script>

<style scoped>
/* Ensure dialog is keyboard accessible */
:deep(.v-overlay__content) {
  outline: none;
}

/* Focus styling for dialog title */
:deep(.v-card__title:focus-visible) {
  outline: 2px solid #11298a;
  outline-offset: 2px;
}
</style>
