export default class UserDTO {
  /** @type {string} */
  id
  /** @type {string} */
  name

  constructor (data = null) {
    this.id = data?.id
    this.name = data?.name
  }
}