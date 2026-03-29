<template>
  <div v-if="!isAuthenticated" class="auth-guard">
    <div class="auth-container">
      <h2>Access Denied</h2>
      <p>Please log in to view your reports.</p>
      <NuxtLink to="/login" class="btn btn-primary">Go to Login</NuxtLink>
    </div>
  </div>
  <div v-else class="reports-page">
    <!-- Header -->
    <div class="page-header">
      <div class="header-container">
        <div class="header-content">
          <h1>My Reports</h1>
          <p class="header-subtitle">Manage and download your ESG reports</p>
        </div>
        <div class="header-actions">
          <button 
            class="btn btn-secondary btn-lg"
            @click="importDialogOpen = true"
            title="Import reports from Excel file"
          >
            📥 Import Reports
          </button>
          <NuxtLink to="/reports/create" class="btn btn-primary btn-lg">
            + Create New Report
          </NuxtLink>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
      <div class="filters-container">
        <!-- Search Filter -->
        <div class="filter-group">
          <label for="search-reports" class="filter-label">Search Reports</label>
          <input
            id="search-reports"
            v-model="searchQuery"
            type="text"
            class="filter-input"
            placeholder="Search by report name or description..."
          />
        </div>

        <!-- Date Range Filter -->
        <div class="filter-group">
          <label for="filter-start-date" class="filter-label">Period From</label>
          <input
            id="filter-start-date"
            v-model="filterStartDate"
            type="date"
            class="filter-input"
          />
        </div>

        <div class="filter-group">
          <label for="filter-end-date" class="filter-label">Period To</label>
          <input
            id="filter-end-date"
            v-model="filterEndDate"
            type="date"
            class="filter-input"
          />
        </div>

        <!-- Clear Filters Button -->
        <button
          v-if="hasActiveFilters"
          class="btn btn-secondary btn-sm"
          @click="clearFilters"
        >
          Clear Filters
        </button>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="loading-state">
      <div class="spinner" />
      <p>Loading reports...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="errorMessage" class="error-state">
      <div class="error-icon">⚠️</div>
      <h2>Something went wrong</h2>
      <p>{{ errorMessage }}</p>
      <button class="btn btn-primary" @click="fetchReports">
        Try Again
      </button>
    </div>

    <!-- Empty State -->
    <div v-else-if="filteredReports.length === 0" class="empty-state">
      <div class="empty-icon">📋</div>
      <h2>{{ hasActiveFilters ? 'No reports match your filters' : 'No reports yet' }}</h2>
      <p>{{ hasActiveFilters ? 'Try adjusting your search or date filters' : 'Create your first ESG report to get started' }}</p>
      <div v-if="hasActiveFilters" class="empty-actions">
        <button class="btn btn-secondary" @click="clearFilters">
          Clear Filters
        </button>
        <NuxtLink to="/reports/create" class="btn btn-primary">
          Create New Report
        </NuxtLink>
      </div>
      <div v-else class="empty-actions">
        <NuxtLink to="/reports/create" class="btn btn-primary">
          Create First Report
        </NuxtLink>
      </div>
    </div>

    <!-- Reports Grid -->
    <div v-else class="reports-grid">
      <div v-for="report in filteredReports" :key="report.id" class="report-card">
        <!-- Card Header with Title and Download -->
        <div class="card-header">
          <div class="card-title-section">
            <h3 class="card-title">{{ report.name }}</h3>
            <button
              class="btn-icon btn-download"
              :disabled="downloadingId === report.id"
              :title="`Download PDF for ${report.name}`"
              @click="downloadPdf(report.id)"
            >
              <span v-if="downloadingId === report.id" class="spinner-small" />
              <span v-else class="icon">↓</span>
            </button>
          </div>
          <p class="card-date">{{ formatDate(report.created_at) }}</p>
        </div>

        <!-- Card Body -->
        <div class="card-body">
          <!-- Description -->
          <p class="card-description">{{ truncateText(report.description, 120) }}</p>

          <!-- Date Range -->
          <div class="date-range">
            <span class="date-label">Period:</span>
            <span class="date-value">
              {{ formatDate(report.start_date) }} - {{ formatDate(report.end_date) }}
            </span>
          </div>

          <!-- Status Badge -->
          <div class="card-status">
            <span class="status-badge" :class="getStatusClass(report)">
              {{ getStatus(report) }}
            </span>
          </div>
        </div>

        <!-- Card Footer with Actions -->
        <div class="card-footer">
          <button
            class="btn btn-primary btn-sm"
            :disabled="generatingId === report.id"
            @click="generatePdf(report.id)"
          >
            <span v-if="generatingId === report.id" class="spinner-small" />
            <span v-else>⚙️ Generate</span>
          </button>
          <button
            class="btn btn-secondary btn-sm"
            @click="editReport(report.id)"
          >
            ✎ Edit
          </button>
          <button
            class="btn btn-danger btn-sm"
            :disabled="deletingId === report.id"
            @click="confirmDelete(report.id, report.name)"
          >
            <span v-if="deletingId === report.id" class="spinner-small" />
            <span v-else>🗑 Delete</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <Teleport to="body">
      <Transition name="modal-fade">
        <div v-if="showDeleteModal" class="modal-overlay" @click.self="cancelDelete">
          <div class="modal-content">
            <h2>Delete Report</h2>
            <p>
              Are you sure you want to delete <strong>{{ reportToDelete?.name }}</strong>?
              This action cannot be undone.
            </p>
            <div class="modal-actions">
              <button
                class="btn btn-secondary"
                @click="cancelDelete"
              >
                Cancel
              </button>
              <button
                class="btn btn-danger"
                :disabled="deletingId === reportToDelete?.id"
                @click="performDelete"
              >
                <span v-if="deletingId === reportToDelete?.id" class="spinner-small" />
                <span v-else>Delete Report</span>
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- Toast Notifications -->
    <Teleport to="body">
      <Transition name="slide-up">
        <div v-if="toast.show" class="toast" :class="toast.type">
          {{ toast.message }}
        </div>
      </Transition>
    </Teleport>

    <!-- Report Import Dialog -->
    <ReportImportDialog 
      :open="importDialogOpen"
      @update:open="importDialogOpen = $event"
      @import-complete="handleImportComplete"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '~/stores/auth'
import { useReportApi } from '~/composables/useReportApi'
import ReportImportDialog from '~/components/ReportImportDialog.vue'
import type { ImportResult } from '~/composables/useReportImport'

interface Report {
  id: number
  name: string
  description: string
  start_date: string
  end_date: string
  created_at: string
  updated_at: string
}

interface Toast {
  show: boolean
  message: string
  type: 'success' | 'error' | 'info'
}

const router = useRouter()
const authStore = useAuthStore()
const { listReports, deleteReport } = useReportApi()
const { $api } = useNuxtApp()

const reports = ref<Report[]>([])
const isLoading = ref(false)
const downloadingId = ref<number | null>(null)
const generatingId = ref<number | null>(null)
const deletingId = ref<number | null>(null)
const showDeleteModal = ref(false)
const reportToDelete = ref<Report | null>(null)
const importDialogOpen = ref(false)
const errorMessage = ref<string | null>(null)

// Filter state
const searchQuery = ref('')
const filterStartDate = ref('')
const filterEndDate = ref('')

const toast = ref<Toast>({
  show: false,
  message: '',
  type: 'info',
})

const isAuthenticated = computed(() => authStore.isLoggedIn)

/**
 * Filter reports based on search query and date range
 */
const filteredReports = computed(() => {
  return reports.value.filter((report) => {
    // Search filter: match name or description (case-insensitive)
    const matchesSearch = searchQuery.value === '' || 
      report.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      report.description.toLowerCase().includes(searchQuery.value.toLowerCase())

    if (!matchesSearch) return false

    // Date range filter: report period should overlap with filter range
    // Report is included if:
    // - Filter start date is empty, OR
    // - Filter end date is empty, OR
    // - Report's end_date >= filter start_date AND Report's start_date <= filter end_date
    if (filterStartDate.value || filterEndDate.value) {
      const reportStart = new Date(report.start_date)
      const reportEnd = new Date(report.end_date)
      
      if (filterStartDate.value) {
        const filterStart = new Date(filterStartDate.value)
        // Report must end on or after the filter start date
        if (reportEnd < filterStart) return false
      }
      
      if (filterEndDate.value) {
        const filterEnd = new Date(filterEndDate.value)
        // Report must start on or before the filter end date
        if (reportStart > filterEnd) return false
      }
    }

    return true
  })
})

/**
 * Check if any filters are active
 */
const hasActiveFilters = computed(() => {
  return searchQuery.value !== '' || filterStartDate.value !== '' || filterEndDate.value !== ''
})

/**
 * Load reports on page mount
 */
onMounted(async () => {
  if (!isAuthenticated.value) {
    router.push('/login')
    return
  }

  await fetchReports()
})

/**
 * Fetch all reports from API
 */
const fetchReports = async () => {
  try {
    isLoading.value = true
    errorMessage.value = null
    const data = await listReports()
    reports.value = Array.isArray(data) ? data : []
  }
  catch (error: any) {
    console.error('Failed to load reports:', error)
    const message = error.message || 'Failed to load reports. Please try again.'
    errorMessage.value = message
    showToast(message, 'error')
  }
  finally {
    isLoading.value = false
  }
}

/**
 * Clear all active filters
 */
const clearFilters = () => {
  searchQuery.value = ''
  filterStartDate.value = ''
  filterEndDate.value = ''
}

/**
 * Format date to DD.MM.YYYY format
 */
const formatDate = (dateString: string): string => {
  if (!dateString)
    return '--'
  try {
    const date = new Date(dateString)
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')
    const year = date.getFullYear()
    return `${day}.${month}.${year}`
  }
  catch {
    return '--'
  }
}

/**
 * Truncate text to specified length
 */
const truncateText = (text: string, length: number): string => {
  if (!text)
    return ''
  return text.length > length ? `${text.substring(0, length)}...` : text
}

/**
 * Get completion percentage for a report
 * Calculate based on filled sections from report data
 */
const getCompletionPercentage = (report: Report & { [key: string]: any }): number => {
  let filledSections = 0
  const totalSections = 9

  // Step 1: Check metadata (name, description, dates)
  if (report.name && report.description && report.start_date && report.end_date) {
    filledSections += 1
  }

  // Steps 2-8: Check if section objects exist and have content
  const sectionKeys = ['section1', 'section2', 'section3', 'section4', 'section5', 'section6', 'section7']
  for (const key of sectionKeys) {
    if (report[key] && typeof report[key] === 'object' && Object.keys(report[key]).length > 0) {
      filledSections += 1
    }
  }

  // Step 9: Check frameworks/certifications
  const frameworksCount = Array.isArray(report.frameworks) ? report.frameworks.length : 0
  const certificationsCount = Array.isArray(report.certifications) ? report.certifications.length : 0
  if (frameworksCount > 0 || certificationsCount > 0) {
    filledSections += 1
  }

  const percentage = Math.round((filledSections / totalSections) * 100)
  return Math.min(100, Math.max(10, percentage))
}

/**
 * Get status badge text based on completion
 */
const getStatus = (report: Report): string => {
  const completion = getCompletionPercentage(report)
  if (completion === 100)
    return 'Complete'
  if (completion >= 75)
    return 'Nearly Done'
  if (completion >= 50)
    return 'In Progress'
  return 'Started'
}

/**
 * Get status badge CSS class
 */
const getStatusClass = (report: Report): string => {
  const completion = getCompletionPercentage(report)
  if (completion === 100)
    return 'status-complete'
  if (completion >= 75)
    return 'status-nearly-done'
  if (completion >= 50)
    return 'status-in-progress'
  return 'status-started'
}

/**
 * Navigate to edit page
 */
const editReport = (reportId: number) => {
  router.push(`/reports/create?reportId=${reportId}`)
}

/**
 * Download PDF for a report
 */
const downloadPdf = async (reportId: number) => {
  try {
    downloadingId.value = reportId
    
    const response = await $api.get(
      `/api/reports/${reportId}/generate-pdf`,
      {
        responseType: 'blob',
      },
    )

    // Create blob download
    const blob = new Blob([response.data], { type: 'application/pdf' })
    const url = window.URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    const report = reports.value.find(r => r.id === reportId)
    link.download = `${report?.name || 'report'}-${formatDate(new Date().toISOString())}.pdf`
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    window.URL.revokeObjectURL(url)

    showToast('PDF downloaded successfully', 'success')
  }
  catch (error: any) {
    console.error('Failed to download PDF:', error)
    showToast('Failed to download PDF', 'error')
  }
  finally {
    downloadingId.value = null
  }
}

/**
 * Generate PDF for a report (trigger creation and download automatically)
 */
const generatePdf = async (reportId: number) => {
  try {
    generatingId.value = reportId
    
    const response = await $api.get(
      `/api/reports/${reportId}/generate-pdf`,
      {
        responseType: 'blob',
      },
    )

    // Get report name for filename
    const report = reports.value.find(r => r.id === reportId)
    const fileName = report 
      ? `${report.name.replace(/\s+/g, '-')}.pdf`
      : 'report.pdf'

    // Create blob URL and trigger download
    const url = window.URL.createObjectURL(response.data as Blob)
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', fileName)
    document.body.appendChild(link)
    link.click()
    link.remove()
    window.URL.revokeObjectURL(url)

    showToast('PDF generated and downloaded successfully', 'success')
  }
  catch (error: any) {
    console.error('Failed to generate PDF:', error)
    showToast('Failed to generate PDF', 'error')
  }
  finally {
    generatingId.value = null
  }
}

/**
 * Show delete confirmation modal
 */
const confirmDelete = (reportId: number, reportName: string) => {
  reportToDelete.value = {
    id: reportId,
    name: reportName,
    description: '',
    start_date: '',
    end_date: '',
    created_at: '',
    updated_at: '',
  }
  showDeleteModal.value = true
}

/**
 * Cancel delete operation
 */
const cancelDelete = () => {
  showDeleteModal.value = false
  reportToDelete.value = null
}

/**
 * Perform delete operation
 */
const performDelete = async () => {
  if (!reportToDelete.value)
    return

  try {
    deletingId.value = reportToDelete.value.id
    await deleteReport(reportToDelete.value.id)
    reports.value = reports.value.filter(r => r.id !== reportToDelete.value!.id)
    showToast(`Report "${reportToDelete.value.name}" deleted successfully`, 'success')
  }
  catch (error: any) {
    console.error('Failed to delete report:', error)
    showToast('Failed to delete report', 'error')
  }
  finally {
    deletingId.value = null
    cancelDelete()
  }
}

/**
 * Show toast notification
 */
const showToast = (message: string, type: 'success' | 'error' | 'info' = 'info') => {
  toast.value = { show: true, message, type }
  setTimeout(() => {
    toast.value.show = false
  }, 3000)
}

/**
 * Handle import completion
 */
const handleImportComplete = async (result: ImportResult) => {
  if (result.successCount > 0) {
    showToast(`Successfully imported ${result.successCount} report(s)`, 'success')
  }
  if (result.failureCount > 0) {
    showToast(`${result.failureCount} row(s) failed to import. Check the dialog for details.`, 'info')
  }
  
  // Refresh reports list
  await fetchReports()
}
</script>

<style scoped>
/* ════════════════════════════════════════════════════════════════════════════ */
/* Layout */
/* ════════════════════════════════════════════════════════════════════════════ */

.reports-page {
  min-height: 100vh;
  background: #f5f7fa;
  padding: 0;
}

.page-header {
  /* position: sticky; */
  top: 0;
  z-index: 40;
  width: 100%;
  background: #f5f7fa;
  border-bottom: 1px solid #e5e7eb;
  padding: 0;
  margin-bottom: 0;
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 2rem;
  padding: 2rem;
  max-width: 1400px;
  margin: 0 auto;
}

.header-content h1 {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.header-subtitle {
  font-size: 1rem;
  color: #6b7280;
  margin: 0;
}

.header-actions {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
  justify-content: flex-end;
  align-items: center;
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* Filters */
/* ════════════════════════════════════════════════════════════════════════════ */

.filters-section {
  background: white;
  border-radius: 0.75rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
  margin: 2rem auto;
  max-width: 1400px;
  width: calc(100% - 4rem);
}

.filters-container {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
  align-items: flex-end;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  flex: 1;
  min-width: 200px;
}

.filter-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #374151;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.filter-input {
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 1rem;
  transition: all 0.2s;
}

.filter-input:focus {
  outline: none;
  border-color: #1e3a8a;
  box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* States */
/* ════════════════════════════════════════════════════════════════════════════ */

.auth-guard {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  text-align: center;
  background: #f5f7fa;
  padding: 2rem;
}

.loading-state,
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 60vh;
  text-align: center;
  margin: 2rem auto;
  padding: 2rem;
  max-width: 1400px;
  width: calc(100% - 4rem);
}

.auth-container,
.empty-state {
  background: white;
  padding: 3rem 2rem;
  border-radius: 0.75rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  max-width: 500px;
  margin: 0 auto;
}

.empty-icon {
  font-size: 4rem;
  margin-bottom: 1.5rem;
}

.empty-state h2 {
  font-size: 1.5rem;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.empty-state p,
.auth-container p {
  color: #6b7280;
  margin: 0 0 1.5rem 0;
}

.empty-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.loading-state {
  gap: 1rem;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #e5e7eb;
  border-top-color: #1e3a8a;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

.spinner-small {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid #e5e7eb;
  border-top-color: currentColor;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* Reports Grid */
/* ════════════════════════════════════════════════════════════════════════════ */

.reports-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
  max-width: 1400px;
  margin: 0 auto 2rem auto;
  padding: 0 2rem;
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* Report Card */
/* ════════════════════════════════════════════════════════════════════════════ */

.report-card {
  background: white;
  border-radius: 0.75rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
}

.report-card:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Card Header */
/* ────────────────────────────────────────────────────────────────────────── */

.card-header {
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
}

.card-title-section {
  flex: 1;
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
}

.card-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
  flex: 1;
}

.card-date {
  font-size: 0.875rem;
  color: #9ca3af;
  margin: 0;
  white-space: nowrap;
}

.btn-icon {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.25rem;
  color: #6b7280;
  font-size: 1.25rem;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
}

.btn-icon:hover:not(:disabled) {
  color: #1e3a8a;
  background: #f0f4ff;
  border-radius: 0.375rem;
}

.btn-icon:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Card Body */
/* ────────────────────────────────────────────────────────────────────────── */

.card-body {
  padding: 1.5rem;
  flex: 1;
}

.card-description {
  font-size: 0.9375rem;
  color: #4b5563;
  margin: 0 0 1rem 0;
  line-height: 1.5;
}

.date-range {
  display: flex;
  gap: 0.5rem;
  font-size: 0.875rem;
  margin-bottom: 1.25rem;
}

.date-label {
  color: #6b7280;
  font-weight: 500;
}

.date-value {
  color: #1f2937;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Status Badge */
/* ────────────────────────────────────────────────────────────────────────── */

.card-status {
  display: flex;
  gap: 0.5rem;
}

.status-badge {
  display: inline-block;
  padding: 0.375rem 0.75rem;
  border-radius: 0.25rem;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.status-complete {
  background: #d1fae5;
  color: #065f46;
}

.status-nearly-done {
  background: #fef3c7;
  color: #92400e;
}

.status-in-progress {
  background: #dbeafe;
  color: #0c4a6e;
}

.status-started {
  background: #f3f4f6;
  color: #374151;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Card Footer */
/* ────────────────────────────────────────────────────────────────────────── */

.card-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid #e5e7eb;
  display: flex;
  gap: 0.75rem;
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* Buttons */
/* ════════════════════════════════════════════════════════════════════════════ */

.btn {
  padding: 0.5625rem 1rem;
  border: none;
  border-radius: 0.375rem;
  font-size: 0.9375rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  text-decoration: none;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-primary {
  background: #1e3a8a;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #1e40af;
  box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
}

.btn-primary.btn-lg {
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
}

.btn-secondary {
  background: #f3f4f6;
  color: #374151;
}

.btn-secondary:hover:not(:disabled) {
  background: #e5e7eb;
}

.btn-danger {
  background: #fee2e2;
  color: #7f1d1d;
}

.btn-danger:hover:not(:disabled) {
  background: #fecaca;
}

.btn-sm {
  padding: 0.375rem 0.75rem;
  font-size: 0.875rem;
  flex: 1;
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* Modal */
/* ════════════════════════════════════════════════════════════════════════════ */

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 0.75rem;
  padding: 2rem;
  max-width: 500px;
  box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
}

.modal-content h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 1rem 0;
}

.modal-content p {
  color: #6b7280;
  margin: 0 0 1.5rem 0;
  line-height: 1.6;
}

.modal-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* Toast */
/* ════════════════════════════════════════════════════════════════════════════ */

.toast {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  padding: 1rem 1.5rem;
  border-radius: 0.375rem;
  font-size: 0.9375rem;
  font-weight: 500;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  z-index: 1001;
  max-width: 400px;
}

.toast.success {
  background: #d1fae5;
  color: #065f46;
  border-left: 4px solid #10b981;
}

.toast.error {
  background: #fee2e2;
  color: #7f1d1d;
  border-left: 4px solid #ef4444;
}

.toast.info {
  background: #dbeafe;
  color: #0c4a6e;
  border-left: 4px solid #3b82f6;
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* Transitions */
/* ════════════════════════════════════════════════════════════════════════════ */

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.3s ease;
}

.slide-up-enter-from,
.slide-up-leave-to {
  transform: translateY(100%);
  opacity: 0;
}

/* ════════════════════════════════════════════════════════════════════════════ */
/* Responsive */
/* ════════════════════════════════════════════════════════════════════════════ */

@media (max-width: 1024px) {
  .reports-grid {
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  }

  .page-header {
    flex-direction: column;
    gap: 1rem;
  }

  .reports-page {
    padding: 1.5rem;
  }
}

@media (max-width: 640px) {
  .reports-grid {
    grid-template-columns: 1fr;
  }

  .page-header {
    margin-bottom: 2rem;
  }

  .header-content h1 {
    font-size: 1.5rem;
  }

  .card-footer {
    flex-direction: column;
  }

  .btn-sm {
    flex: auto;
  }

  .toast {
    left: 1rem;
    right: 1rem;
    bottom: 1rem;
    max-width: none;
  }
}
</style>
