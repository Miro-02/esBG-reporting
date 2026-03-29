/**
 * Accessibility Utilities Composable
 * Provides helpers for focus management, keyboard event handling, and ARIA attributes
 * Ensures WCAG 2.1 Level AA compliance across the application
 */

import { ref, nextTick, watch } from 'vue'

/**
 * Focus Management
 * Used for modal dialogs, dropdowns, and focus restoration
 */
export function useFocusManagement() {
  const previouslyFocusedElement = ref<HTMLElement | null>(null)

  /**
   * Store the currently focused element and optionally move focus to a new element
   */
  const saveFocusAndShift = async (targetElement: HTMLElement | string | null) => {
    previouslyFocusedElement.value = (document.activeElement as HTMLElement) || null
    
    if (targetElement) {
      await nextTick()
      const target = typeof targetElement === 'string' 
        ? document.querySelector(targetElement) as HTMLElement
        : targetElement
      
      if (target) {
        target.focus()
      }
    }
  }

  /**
   * Restore focus to the previously saved element
   */
  const restoreFocus = () => {
    if (previouslyFocusedElement.value) {
      previouslyFocusedElement.value.focus()
    }
  }

  /**
   * Focus the first focusable element within a container
   */
  const focusFirstElement = async (container: HTMLElement | null) => {
    if (!container) return
    
    await nextTick()
    const focusableElements = container.querySelectorAll(
      'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
    )
    
    if (focusableElements.length > 0) {
      (focusableElements[0] as HTMLElement).focus()
    }
  }

  /**
   * Create a focus trap: keep focus within a container (for modals, dialogs)
   */
  const createFocusTrap = (container: HTMLElement | null) => {
    if (!container) return () => {}

    const handleKeyDown = (event: KeyboardEvent) => {
      if (event.key !== 'Tab') return

      const focusableElements = container.querySelectorAll(
        'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
      )

      if (focusableElements.length === 0) return

      const firstElement = focusableElements[0] as HTMLElement
      const lastElement = focusableElements[focusableElements.length - 1] as HTMLElement

      if (event.shiftKey) {
        if (document.activeElement === firstElement) {
          lastElement.focus()
          event.preventDefault()
        }
      } else {
        if (document.activeElement === lastElement) {
          firstElement.focus()
          event.preventDefault()
        }
      }
    }

    container.addEventListener('keydown', handleKeyDown)

    return () => {
      container.removeEventListener('keydown', handleKeyDown)
    }
  }

  return {
    saveFocusAndShift,
    restoreFocus,
    focusFirstElement,
    createFocusTrap,
    previouslyFocusedElement
  }
}

/**
 * Keyboard Event Handlers
 * Standardized keyboard interactions (Enter, Space, Escape, Arrow keys)
 */
export function useKeyboardNavigation() {
  /**
   * Handle Enter and Space keys for buttons
   */
  const handleActivationKeys = (event: KeyboardEvent, callback: () => void) => {
    if (event.key === 'Enter' || event.key === ' ') {
      event.preventDefault()
      callback()
    }
  }

  /**
   * Handle Escape key for closing modals/menus
   */
  const handleEscapeKey = (event: KeyboardEvent, callback: () => void) => {
    if (event.key === 'Escape') {
      event.preventDefault()
      callback()
    }
  }

  /**
   * Handle Arrow keys for navigation in dropdowns, selects, carousels
   */
  const handleArrowKeys = (
    event: KeyboardEvent,
    options: {
      onUp?: () => void
      onDown?: () => void
      onLeft?: () => void
      onRight?: () => void
    }
  ) => {
    if (event.key === 'ArrowUp' && options.onUp) {
      event.preventDefault()
      options.onUp()
    } else if (event.key === 'ArrowDown' && options.onDown) {
      event.preventDefault()
      options.onDown()
    } else if (event.key === 'ArrowLeft' && options.onLeft) {
      event.preventDefault()
      options.onLeft()
    } else if (event.key === 'ArrowRight' && options.onRight) {
      event.preventDefault()
      options.onRight()
    }
  }

  /**
   * Check if a key event is an activation key (Enter or Space)
   */
  const isActivationKey = (event: KeyboardEvent): boolean => {
    return event.key === 'Enter' || event.key === ' '
  }

  /**
   * Check if a key event is an escape key
   */
  const isEscapeKey = (event: KeyboardEvent): boolean => {
    return event.key === 'Escape'
  }

  /**
   * Check if a key event is an arrow key
   */
  const isArrowKey = (event: KeyboardEvent): boolean => {
    return ['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(event.key)
  }

  return {
    handleActivationKeys,
    handleEscapeKey,
    handleArrowKeys,
    isActivationKey,
    isEscapeKey,
    isArrowKey
  }
}

/**
 * ARIA Attribute Helpers
 * Utilities for setting and managing ARIA attributes
 */
export function useAriaAttributes() {
  /**
   * Update multiple ARIA attributes at once
   */
  const setAriaAttributes = (element: HTMLElement, attributes: Record<string, string | boolean | null>) => {
    Object.entries(attributes).forEach(([key, value]) => {
      if (value === null || value === false) {
        element.removeAttribute(`aria-${key}`)
      } else {
        element.setAttribute(`aria-${key}`, String(value))
      }
    })
  }

  /**
   * Create an aria-label for an element
   */
  const setAriaLabel = (element: HTMLElement, label: string) => {
    element.setAttribute('aria-label', label)
  }

  /**
   * Create aria-labelledby relationship
   */
  const setAriaLabelledBy = (element: HTMLElement, ids: string[]) => {
    element.setAttribute('aria-labelledby', ids.join(' '))
  }

  /**
   * Create aria-describedby relationship for error messages, hints
   */
  const setAriaDescribedBy = (element: HTMLElement, ids: string[]) => {
    element.setAttribute('aria-describedby', ids.join(' '))
  }

  /**
   * Set aria-expanded state for collapsible content
   */
  const setAriaExpanded = (element: HTMLElement, isExpanded: boolean) => {
    element.setAttribute('aria-expanded', isExpanded ? 'true' : 'false')
  }

  /**
   * Set aria-selected state for tabs, options
   */
  const setAriaSelected = (element: HTMLElement, isSelected: boolean) => {
    element.setAttribute('aria-selected', isSelected ? 'true' : 'false')
  }

  /**
   * Set aria-current for active navigation
   */
  const setAriaCurrent = (element: HTMLElement, current: 'page' | 'step' | 'location' | 'date' | 'time' | null = null) => {
    if (current) {
      element.setAttribute('aria-current', current)
    } else {
      element.removeAttribute('aria-current')
    }
  }

  /**
   * Set aria-live region for dynamic content updates
   */
  const setAriaLive = (element: HTMLElement, politeness: 'polite' | 'assertive' | 'off' = 'polite') => {
    element.setAttribute('aria-live', politeness)
  }

  /**
   * Set aria-invalid for form validation
   */
  const setAriaInvalid = (element: HTMLElement, isInvalid: boolean) => {
    element.setAttribute('aria-invalid', isInvalid ? 'true' : 'false')
  }

  /**
   * Set aria-busy for loading states
   */
  const setAriaBusy = (element: HTMLElement, isBusy: boolean) => {
    element.setAttribute('aria-busy', isBusy ? 'true' : 'false')
  }

  /**
   * Set aria-disabled for custom disabled elements
   */
  const setAriaDisabled = (element: HTMLElement, isDisabled: boolean) => {
    element.setAttribute('aria-disabled', isDisabled ? 'true' : 'false')
    if (isDisabled) {
      element.setAttribute('tabindex', '-1')
    } else {
      element.removeAttribute('tabindex')
    }
  }

  /**
   * Create a hidden screen-reader only element for context
   */
  const createScreenReaderText = (text: string, id?: string): HTMLElement => {
    const element = document.createElement('span')
    element.classList.add('sr-only')
    element.textContent = text
    if (id) {
      element.id = id
    }
    return element
  }

  return {
    setAriaAttributes,
    setAriaLabel,
    setAriaLabelledBy,
    setAriaDescribedBy,
    setAriaExpanded,
    setAriaSelected,
    setAriaCurrent,
    setAriaLive,
    setAriaInvalid,
    setAriaBusy,
    setAriaDisabled,
    createScreenReaderText
  }
}

/**
 * Composite: All accessibility utilities in one composable
 */
export function useAccessibility() {
  const focus = useFocusManagement()
  const keyboard = useKeyboardNavigation()
  const aria = useAriaAttributes()

  return {
    ...focus,
    ...keyboard,
    ...aria
  }
}
