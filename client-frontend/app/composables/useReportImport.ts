import { ref } from 'vue'

export interface ImportFailure {
  rowNumber: number
  reportName?: string
  errors: string[]
}

export interface ImportResult {
  totalRows: number
  successCount: number
  failureCount: number
  createdReportIds: number[]
  failures: ImportFailure[]
}

const isLoading = ref(false)
const error = ref<string | null>(null)

export const useReportImport = () => {
  const { $api } = useNuxtApp()

  /**
   * Import reports from an Excel file
   */
  const importReports = async (file: File): Promise<ImportResult | null> => {
    isLoading.value = true
    error.value = null

    try {
      const formData = new FormData()
      formData.append('file', file)

      const response = await $api.post<ImportResult>('/api/reports/import', formData)
      return response.data

    } catch (err: any) {
      if (err.response?.data?.failures) {
        // API returned validation errors
        const failures = err.response.data.failures as ImportFailure[]
        error.value = `Import failed: ${failures[0]?.errors[0] || 'Unknown error'}`
      } else if (err.response?.data?.message) {
        error.value = err.response.data.message
      } else {
        error.value = err instanceof Error ? err.message : 'An unknown error occurred during import'
      }
      console.error('Import error:', err)
      return null
    } finally {
      isLoading.value = false
    }
  }

  /**
   * Get formatted error message from failures
   */
  const getErrorSummary = (result: ImportResult): string => {
    if (result.failureCount === 0 || !result.failures || result.failures.length === 0) {
      return ''
    }

    if (result.failureCount === 1) {
      const failure = result.failures[0]
      if (failure) {
        return `Row ${failure.rowNumber}: ${failure.errors.join(', ')}`
      }
    }

    return `${result.failureCount} rows failed to import`
  }

  /**
   * Format detailed failure list for display
   */
  const getDetailedFailures = (result: ImportResult): string[] => {
    if (!result.failures || result.failures.length === 0) {
      return []
    }

    return result.failures.map((failure) => {
      const rowInfo = `Row ${failure.rowNumber}`
      const nameInfo = failure.reportName ? ` (${failure.reportName})` : ''
      const errors = failure.errors.join('; ')
      return `${rowInfo}${nameInfo}: ${errors}`
    })
  }

  return {
    isLoading,
    error,
    importReports,
    getErrorSummary,
    getDetailedFailures,
  }
}
