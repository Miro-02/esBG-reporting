<template>
  <AppDialog
    :model-value="isOpen"
    @update:model-value="isOpen = $event"
    title="Import Reports"
  >
    <div class="import-dialog">
      <!-- Step 1: File Upload -->
      <div v-if="!importResult && !isImporting" class="upload-section">
        <p class="mb-4 text-gray-700">
          Upload an Excel file (.xlsx or .xls) containing report data. Each row represents one report.
        </p>

        <!-- File Input Area -->
        <div
          class="upload-area"
          @dragover.prevent="isDragging = true"
          @dragleave.prevent="isDragging = false"
          @drop.prevent="handleDrop"
          :class="{ 'dragging': isDragging }"
        >
          <input
            ref="fileInput"
            type="file"
            accept=".xlsx,.xls"
            class="hidden"
            @change="handleFileSelect"
          />

          <div class="text-center pointer-events-none">
            <div class="mb-2 text-2xl">📁</div>
            <p class="font-medium text-gray-800">Drag and drop your Excel file here</p>
            <p class="text-sm text-gray-500">or click to browse</p>
          </div>

          <button
            @click="fileInput?.click()"
            class="absolute inset-0 w-full h-full cursor-pointer opacity-0"
            type="button"
          ></button>
        </div>

        <!-- Selected File Display -->
        <div v-if="selectedFile" class="mt-4 p-3 bg-blue-50 rounded border border-blue-200">
          <p class="text-sm text-blue-900">
            <strong>Selected:</strong> {{ selectedFile.name }}
            <span class="text-gray-600 ml-2">({{ formatFileSize(selectedFile.size) }})</span>
          </p>
        </div>

        <!-- Error Display -->
        <div v-if="error" class="mt-4 p-3 bg-red-50 rounded border border-red-200">
          <p class="text-sm text-red-900">{{ error }}</p>
        </div>

        <!-- Import Button -->
        <div class="mt-6 flex justify-end gap-2">
          <AppButton
            variant="secondary"
            @click="isOpen = false"
          >
            Cancel
          </AppButton>
          <AppButton
            variant="primary"
            :disabled="!selectedFile"
            @click="handleImport"
          >
            Import Reports
          </AppButton>
        </div>
      </div>

      <!-- Step 2: Importing -->
      <div v-if="isImporting && !importResult" class="importing-section text-center">
        <div class="mb-4">
          <div class="inline-block">
            <div class="spinner"></div>
          </div>
        </div>
        <p class="text-gray-700 font-medium">Importing reports...</p>
        <p class="text-sm text-gray-500 mt-2">Please wait, this may take a moment</p>
      </div>

      <!-- Step 3: Results -->
      <div v-if="importResult" class="results-section">
        <!-- Success Summary -->
        <div v-if="importResult.successCount > 0" class="mb-6 p-4 bg-green-50 rounded border border-green-200">
          <div class="flex items-start gap-3">
            <div class="text-2xl">✓</div>
            <div>
              <p class="font-medium text-green-900">
                {{ importResult.successCount }}
                {{ importResult.successCount === 1 ? 'report' : 'reports' }} imported successfully
              </p>
              <p v-if="importResult.createdReportIds.length" class="text-sm text-green-700 mt-1">
                Report IDs: {{ importResult.createdReportIds.join(', ') }}
              </p>
            </div>
          </div>
        </div>

        <!-- Failure Summary -->
        <div v-if="importResult.failureCount > 0" class="mb-6 p-4 bg-red-50 rounded border border-red-200">
          <div class="flex items-start gap-3">
            <div class="text-2xl">⚠️</div>
            <div class="flex-1">
              <p class="font-medium text-red-900">
                {{ importResult.failureCount }}
                {{ importResult.failureCount === 1 ? 'row' : 'rows' }} failed
              </p>

              <!-- Detailed Failures -->
              <div v-if="importResult.failures.length" class="mt-3 space-y-2">
                <div
                  v-for="(failure, index) in importResult.failures"
                  :key="index"
                  class="text-sm bg-white p-2 rounded border border-red-200"
                >
                  <p class="font-medium text-red-900">
                    Row {{ failure.rowNumber }}
                    <span v-if="failure.reportName" class="text-red-700 ml-1">({{ failure.reportName }})</span>
                  </p>
                  <ul class="mt-1 ml-4 text-red-700 list-disc">
                    <li v-for="(err, i) in failure.errors" :key="i">{{ err }}</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-3 gap-2 mb-6">
          <div class="p-3 bg-gray-50 rounded text-center">
            <p class="text-2xl font-bold text-gray-900">{{ importResult.totalRows }}</p>
            <p class="text-xs text-gray-600 mt-1">Total Rows</p>
          </div>
          <div class="p-3 bg-green-50 rounded text-center">
            <p class="text-2xl font-bold text-green-600">{{ importResult.successCount }}</p>
            <p class="text-xs text-green-600 mt-1">Successful</p>
          </div>
          <div class="p-3 bg-red-50 rounded text-center">
            <p class="text-2xl font-bold text-red-600">{{ importResult.failureCount }}</p>
            <p class="text-xs text-red-600 mt-1">Failed</p>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-2">
          <AppButton
            variant="secondary"
            @click="resetDialog"
          >
            Import Another File
          </AppButton>
          <AppButton
            variant="primary"
            @click="closeAndRefresh"
          >
            Close
          </AppButton>
        </div>
      </div>
    </div>
  </AppDialog>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import AppDialog from '@/components/AppDialog.vue'
import AppButton from '@/components/AppButton.vue'
import { useReportImport, type ImportResult } from '@/composables/useReportImport'

interface Props {
  open: boolean
}

interface Emits {
  (e: 'update:open', value: boolean): void
  (e: 'import-complete', value: ImportResult): void
}

const props = withDefaults(defineProps<Props>(), {
  open: false,
})

const emit = defineEmits<Emits>()

const isOpen = ref(props.open)
const { isLoading: isImporting, error, importReports } = useReportImport()

const fileInput = ref<HTMLInputElement | null>(null)
const selectedFile = ref<File | null>(null)
const isDragging = ref(false)
const importResult = ref<ImportResult | null>(null)

// Sync open prop with local state
watch(() => props.open, (newValue) => {
  isOpen.value = newValue
}, { immediate: true })

// Emit when dialog is closed
watch(isOpen, (newValue) => {
  emit('update:open', newValue)
})

const handleFileSelect = (event: Event) => {
  const input = event.target as HTMLInputElement
  if (input.files) {
    const file = input.files.item(0)
    if (file) {
      selectedFile.value = file
      validateFile(file)
    }
  }
}

const handleDrop = (event: DragEvent) => {
  isDragging.value = false
  if (event.dataTransfer && event.dataTransfer.files) {
    const file = event.dataTransfer.files.item(0)
    if (file) {
      selectedFile.value = file
      validateFile(file)
    }
  }
}

const validateFile = (file: File) => {
  error.value = null

  // Check file type
  if (!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(file.type)) {
    error.value = 'Please upload a valid Excel file (.xlsx or .xls)'
    selectedFile.value = null
    return
  }

  // Check file size (10MB max)
  const maxSize = 10 * 1024 * 1024
  if (file.size > maxSize) {
    error.value = `File size exceeds 10MB limit (${formatFileSize(file.size)})`
    selectedFile.value = null
    return
  }
}

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i]
}

const handleImport = async () => {
  if (!selectedFile.value) return

  const result = await importReports(selectedFile.value)
  if (result) {
    importResult.value = result
    emit('import-complete', result)
  }
}

const resetDialog = () => {
  selectedFile.value = null
  importResult.value = null
  error.value = null
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const closeAndRefresh = () => {
  resetDialog()
  isOpen.value = false
  // Trigger a refresh of the reports list
  window.location.reload()
}
</script>

<style scoped>
.upload-area {
  position: relative;
  border: 2px dashed #cbd5e1;
  border-radius: 0.5rem;
  padding: 3rem 2rem;
  text-align: center;
  transition: all 0.2s ease;
  background-color: #f8fafc;
}

.upload-area:hover {
  border-color: #94a3b8;
  background-color: #f1f5f9;
}

.upload-area.dragging {
  border-color: #3b82f6;
  background-color: #dbeafe;
}

.spinner {
  display: inline-block;
  width: 2rem;
  height: 2rem;
  border: 3px solid #e5e7eb;
  border-top-color: #3b82f6;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
