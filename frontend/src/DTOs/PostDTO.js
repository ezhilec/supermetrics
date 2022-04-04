export default class PostDTO {
  /** @type {string} */
  id
  /** @type {string} */
  fromName
  /** @type {string} */
  fromId
  /** @type {string} */
  message
  /** @type {string} */
  type
  /** @type {string} */
  createdAt

  constructor (data = null) {
    this.id = data?.id
    this.fromName = data?.fromName
    this.fromId = data?.fromId
    this.message = data?.message
    this.type = data?.type
    this.createdAt = data?.createdAt
  }
}