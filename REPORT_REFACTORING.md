# Report Module Refactoring - Implementation Summary

## Overview
The Report module has been refactored to split the monolithic store and update operations into separate, focused endpoints. This improves code organization, maintainability, and client flexibility.

## What Changed

### 1. Request Classes (New Structure)

#### Store Operations
- **StoreReportRequest** - Creates a new report with metadata only
  - `name` (required)
  - `description` (nullable)
  - `start_date` (required)
  - `end_date` (required)

- **StoreReportSection{1-7}Request** - Individual section validation
  - Section 1: Company Profile
  - Section 2: Governance
  - Section 3: Environment
  - Section 4: Social
  - Section 5: Cybersecurity
  - Section 6: Supply Chain
  - Section 7: Targets

#### Update Operations
- **UpdateReportMetadataRequest** - Update report metadata
- **UpdateReportSection{1-7}Request** - Update individual sections

### 2. Service Layer

**ReportService** (`Modules\Reports\Services\ReportService`)
- `createReport()` - Create new report with optional sections
- `updateReportMetadata()` - Update report metadata
- `updateSection()` - Update a specific section
- `createSections()` - Bulk create sections
- `updateFrameworks()` - Update frameworks
- `updateCertifications()` - Update certifications
- `deleteReport()` - Delete report
- `loadAllRelations()` - Load all relationships with eager loading

### 3. Controller Changes

**ReportController** now has focused methods:
- `index()` - List all reports
- `store()` - Create report metadata
- `show()` - Get single report with all sections
- `updateMetadata()` - Update report metadata
- `updateSection{1-7}()` - Update individual sections
- `updateFrameworks()` - Update frameworks
- `updateCertifications()` - Update certifications
- `destroy()` - Delete report
- `generatePdf()` - Generate PDF

### 4. Routes

New API endpoints:
```
POST   /reports                         → Create report
GET    /reports/{report}                → Get report
PUT    /reports/{report}/metadata       → Update metadata
PUT    /reports/{report}/section{N}     → Update section N (1-7)
PUT    /reports/{report}/frameworks     → Update frameworks
PUT    /reports/{report}/certifications → Update certifications
DELETE /reports/{report}                → Delete report
GET    /reports/{report}/generate-pdf   → Generate PDF
```

## Migration Guide for Frontend

### Old API vs New API

**Creating a Report**
```javascript
// Old: Single endpoint with all data
POST /reports
{
  name: "Q1 Report",
  description: "...",
  start_date: "2024-01-01",
  end_date: "2024-03-31",
  section1: { /* company profile */ },
  section2: { /* governance */ },
  // ... all sections at once
  frameworks: [1, 2, 3]
}

// New: Step-by-step approach
// 1. Create report
POST /reports
{
  name: "Q1 Report",
  description: "...",
  start_date: "2024-01-01",
  end_date: "2024-03-31"
}

// 2. Add sections individually
PUT /reports/{reportId}/section1
{ /* company profile */ }

PUT /reports/{reportId}/section2
{ /* governance */ }

// 3. Add frameworks
PUT /reports/{reportId}/frameworks
{ frameworks: [1, 2, 3] }
```

**Updating a Report**
```javascript
// Old: Single endpoint for all updates
PUT /reports/{reportId}
{
  name: "Updated Report",
  section1: { /* updated company profile */ },
  frameworks: [4, 5]
}

// New: Update specific parts
// 1. Update metadata
PUT /reports/{reportId}/metadata
{
  name: "Updated Report",
  description: "..."
}

// 2. Update sections
PUT /reports/{reportId}/section1
{ /* updated company profile */ }

// 3. Update frameworks
PUT /reports/{reportId}/frameworks
{ frameworks: [4, 5] }
```

## Benefits

1. **Separation of Concerns** - Each section has its own validation rules
2. **Progressive Enhancement** - Clients can save partial data at any time
3. **Cleaner Validation** - Smaller, focused request classes
4. **Better Testability** - Easy to test individual operations
5. **Flexibility** - API clients can update only what they need
6. **Scalability** - Easy to add pre/post-processing per section

## Backward Compatibility

The old `UpdateReportRequest` is no longer used. If your frontend relies on the old endpoints:
- `PUT /reports/{reportId}` - **Removed**
- Use `PUT /reports/{reportId}/metadata` + section-specific endpoints instead

## Next Steps

1. Update frontend API calls to use new endpoints
2. Update integration tests to reflect new API structure
3. Consider adding bulk operations if needed (e.g., update multiple sections in one request)
4. Update API documentation
