export default class UserStatisticsDTO {
  /** @type {number} */
  userPostsCount
  /** @type {number} */
  avgMessageLength
  /** @type {array} */
  postsByMonth
  /** @type PostDTO */
  maxMessagePost
  /** @type UserDTO */
  user

  constructor (data = null) {
    this.userPostsCount = data?.userPostsCount
    this.avgMessageLength = data?.avgMessageLength
    this.postsByMonth = data?.postsByMonth
    this.maxMessagePost = data?.maxMessagePost
    this.user = data?.user
  }
}