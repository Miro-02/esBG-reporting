/**
 * Report Dropdowns Composable
 * Fetches dropdown options from API (countries, sectors, legal forms, etc.)
 */

export interface DropdownOption {
  id: number
  name: string
}

interface DropdownsState {
  countries: DropdownOption[]
  sectors: DropdownOption[]
  legalForms: DropdownOption[]
  frameworks: DropdownOption[]
  certifications: DropdownOption[]
  cdpLevels: DropdownOption[]
  ecoVadisRatings: DropdownOption[]
}

export const useReportDropdowns = () => {
  const { $api } = useNuxtApp()

  const isLoading = ref(false)
  const error = ref<string | null>(null)

  const dropdowns = ref<DropdownsState>({
    countries: [],
    sectors: [],
    legalForms: [],
    frameworks: [],
    certifications: [],
    cdpLevels: [],
    ecoVadisRatings: [],
  })

  /**
   * Fetch all dropdown data at once
   */
  const fetchAllDropdowns = async () => {
    isLoading.value = true
    error.value = null

    try {
      const [countries, sectors, legalForms, frameworks, certifications, cdpLevels, ecoVadisRatings] = await Promise.all([
        fetchCountries(),
        fetchSectors(),
        fetchLegalForms(),
        fetchFrameworks(),
        fetchCertifications(),
        fetchCdpLevels(),
        fetchEcoVadisRatings(),
      ])

      dropdowns.value = {
        countries,
        sectors,
        legalForms,
        frameworks,
        certifications,
        cdpLevels,
        ecoVadisRatings,
      }
    }
    catch (err: any) {
      error.value = err.message || 'Failed to fetch dropdown data'
      console.error('Error fetching dropdowns:', err)
    }
    finally {
      isLoading.value = false
    }
  }

  /**
   * Fetch countries
   */
  const fetchCountries = async (): Promise<DropdownOption[]> => {
    try {
      const response = await $api.get<DropdownOption[]>('/api/country')
      return Array.isArray(response.data) ? response.data : []
    }
    catch (error) {
      console.error('Failed to fetch countries:', error)
      return []
    }
  }

  /**
   * Fetch sectors
   */
  const fetchSectors = async (): Promise<DropdownOption[]> => {
    try {
      const response = await $api.get<DropdownOption[]>('/api/sector')
      return Array.isArray(response.data) ? response.data : []
    }
    catch (error) {
      console.error('Failed to fetch sectors:', error)
      return []
    }
  }

  /**
   * Fetch legal forms
   */
  const fetchLegalForms = async (): Promise<DropdownOption[]> => {
    try {
      const response = await $api.get<DropdownOption[]>('/api/framework/legal-forms')
      return Array.isArray(response.data) ? response.data : []
    }
    catch (error) {
      console.error('Failed to fetch legal forms:', error)
      return []
    }
  }

  /**
   * Fetch frameworks
   */
  const fetchFrameworks = async (): Promise<DropdownOption[]> => {
    try {
      const response = await $api.get<DropdownOption[]>('/api/framework/frameworks')
      return Array.isArray(response.data) ? response.data : []
    }
    catch (error) {
      console.error('Failed to fetch frameworks:', error)
      return []
    }
  }

  /**
   * Fetch certifications
   */
  const fetchCertifications = async (): Promise<DropdownOption[]> => {
    try {
      const response = await $api.get<DropdownOption[]>('/api/framework/certifications')
      return Array.isArray(response.data) ? response.data : []
    }
    catch (error) {
      console.error('Failed to fetch certifications:', error)
      return []
    }
  }

  /**
   * Fetch CDP levels
   */
  const fetchCdpLevels = async (): Promise<DropdownOption[]> => {
    try {
      const response = await $api.get<DropdownOption[]>('/api/framework/cdp-levels')
      return Array.isArray(response.data) ? response.data : []
    }
    catch (error) {
      console.error('Failed to fetch CDP levels:', error)
      return []
    }
  }

  /**
   * Fetch EcoVadis ratings
   */
  const fetchEcoVadisRatings = async (): Promise<DropdownOption[]> => {
    try {
      const response = await $api.get<DropdownOption[]>('/api/framework/ecoVadis-ratings')
      return Array.isArray(response.data) ? response.data : []
    }
    catch (error) {
      console.error('Failed to fetch EcoVadis ratings:', error)
      return []
    }
  }

  /**
   * Get a specific dropdown option by id
   */
  const getOptionLabel = (type: keyof DropdownsState, id: number): string => {
    const option = dropdowns.value[type].find(opt => opt.id === id)
    return option?.name || ''
  }

  return {
    isLoading,
    error,
    dropdowns,
    fetchAllDropdowns,
    fetchCountries,
    fetchSectors,
    fetchLegalForms,
    fetchFrameworks,
    fetchCertifications,
    fetchCdpLevels,
    fetchEcoVadisRatings,
    getOptionLabel,
  }
}
