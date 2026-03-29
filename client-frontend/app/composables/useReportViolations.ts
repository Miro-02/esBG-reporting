import { ref, computed } from 'vue'

export interface Violation {
  fieldName: string
  fieldLabel: string
  section: number
  currentValue: any
  currentValueFormatted: string
  standardValue: any
  standardValueFormatted: string
  type: string
}

export interface ViolationsResponse {
  violations: Violation[]
  count: number
}

export function useReportViolations() {
  const violations = ref<Violation[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)
  const violationsCache = ref<Record<number, Violation[]>>({})

  const hasViolations = computed(() => violations.value.length > 0)
  const violationCount = computed(() => violations.value.length)

  const fetchViolations = async (reportId: number) => {
    // Check cache first
    if (violationsCache.value[reportId]) {
      violations.value = violationsCache.value[reportId]
      return
    }

    loading.value = true
    error.value = null

    try {
      const response = await $fetch<{
        data: ViolationsResponse
      }>(`/api/reports/${reportId}/violations`)

      violations.value = response.data.violations
      violationsCache.value[reportId] = response.data.violations
    } catch (err: any) {
      error.value = err.message || 'Failed to fetch violations'
      violations.value = []
    } finally {
      loading.value = false
    }
  }

  const clearCache = (reportId?: number) => {
    if (reportId) {
      delete violationsCache.value[reportId]
    } else {
      violationsCache.value = {}
    }
  }

  return {
    violations,
    loading,
    error,
    hasViolations,
    violationCount,
    fetchViolations,
    clearCache,
  }
}
