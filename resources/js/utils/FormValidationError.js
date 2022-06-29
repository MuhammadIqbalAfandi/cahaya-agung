export default class FormValidationError extends Error {
  constructor(message, field) {
    super(message)
    this.field = field
  }
}
