/**
 * Report API Service Composable
 * Provides all API calls for the report form
 */

import type {
  ReportMetadata,
  ReportSection1,
  ReportSection2,
  ReportSection3,
  ReportSection4,
  ReportSection5,
  ReportSection6,
  ReportSection7,
  ApiReportResponse,
  ApiErrorResponse,
} from '~/types/report'

interface UseReportApiOptions {
  baseUrl?: string
}

export const useReportApi = (options: UseReportApiOptions = {}) => {
  const { $api } = useNuxtApp()
  const baseUrl = options.baseUrl || '/api/reports'

  /**
   * Create a new report with metadata only
   */
  const createReport = async (metadata: ReportMetadata): Promise<ApiReportResponse> => {
    try {
      const response = await $api.post<{ data: ApiReportResponse }>(baseUrl, metadata)
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to create report',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Get a report with all its sections
   */
  const getReport = async (reportId: number): Promise<any> => {
    try {
      const response = await $api.get<{ data: any }>(`${baseUrl}/${reportId}`)
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to fetch report',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update report metadata
   */
  const updateMetadata = async (
    reportId: number,
    metadata: Partial<ReportMetadata>,
  ): Promise<ApiReportResponse> => {
    try {
      const response = await $api.put<{ data: ApiReportResponse }>(
        `${baseUrl}/${reportId}/metadata`,
        metadata,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update metadata',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update Section 1: Company Profile
   */
  const updateSection1 = async (
    reportId: number,
    data: ReportSection1,
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/section1`,
        data,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update section 1',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update Section 2: Governance
   */
  const updateSection2 = async (
    reportId: number,
    data: ReportSection2,
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/section2`,
        data,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update section 2',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update Section 3: Environment
   */
  const updateSection3 = async (
    reportId: number,
    data: ReportSection3,
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/section3`,
        data,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update section 3',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update Section 4: Social
   */
  const updateSection4 = async (
    reportId: number,
    data: ReportSection4,
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/section4`,
        data,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update section 4',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update Section 5: Cybersecurity
   */
  const updateSection5 = async (
    reportId: number,
    data: ReportSection5,
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/section5`,
        data,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update section 5',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update Section 6: Supply Chain
   */
  const updateSection6 = async (
    reportId: number,
    data: ReportSection6,
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/section6`,
        data,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update section 6',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update Section 7: Targets
   */
  const updateSection7 = async (
    reportId: number,
    data: ReportSection7,
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/section7`,
        data,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update section 7',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update frameworks
   */
  const updateFrameworks = async (
    reportId: number,
    frameworks: number[],
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/frameworks`,
        { frameworks },
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update frameworks',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Update certifications
   */
  const updateCertifications = async (
    reportId: number,
    certifications: number[],
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/certifications`,
        { certifications },
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to update certifications',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Generic update section method
   */
  const updateSection = async (
    reportId: number,
    sectionNumber: number,
    data: any,
  ): Promise<any> => {
    try {
      const response = await $api.put<{ data: any }>(
        `${baseUrl}/${reportId}/section${sectionNumber}`,
        data,
      )
      return response.data.data
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message
          || `Failed to update section ${sectionNumber}`,
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * Delete a report
   */
  const deleteReport = async (reportId: number): Promise<void> => {
    try {
      await $api.delete(`${baseUrl}/${reportId}`)
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to delete report',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  /**
   * List all reports
   */
  const listReports = async (): Promise<any[]> => {
    try {
      const response = await $api.get<any>(baseUrl)
      return Array.isArray(response.data) ? response.data : response.data.data || []
    }
    catch (error: any) {
      throw {
        message: error.response?.data?.message || 'Failed to fetch reports',
        errors: error.response?.data?.errors,
      } as ApiErrorResponse
    }
  }

  return {
    createReport,
    getReport,
    updateMetadata,
    updateSection,
    updateSection1,
    updateSection2,
    updateSection3,
    updateSection4,
    updateSection5,
    updateSection6,
    updateSection7,
    updateFrameworks,
    updateCertifications,
    deleteReport,
    listReports,
  }
}
