import React from 'react'
import Pagination from '../../baseComponents/pagination/Pagination'
import Loading from '../../baseComponents/loading/Loading'
import { Link } from 'react-router-dom'
import PropTypes from 'prop-types'

function Posts (props) {
  const {
    posts,
    isLoading,
    page,
    perPage,
    total,
    handleSetPage,
    isShowTitle,
    isShowPagination
  } = props

  const renderItem = (post) => <div className="table__row" key={post.id}>
    <div className="table__cell">{post.createdAt}</div>
    <div className="table__cell"><Link to={`/users/${post.fromId}`}>{post.fromName}</Link></div>
    <div className="table__cell">{post.message}</div>
    <div className="table__cell">{post.type}</div>
  </div>

  const renderList = () => <div className="table">
    <div className="table__head">
      <div className="table__cell">Date</div>
      <div className="table__cell">User</div>
      <div className="table__cell">Message</div>
      <div className="table__cell">Type</div>
    </div>
    <div className="table__body">
      {posts.map((post) =>
        renderItem(post)
      )}
    </div>
  </div>

  return (
    <div className="posts">
      {isShowTitle && <h1>Posts</h1>}

      {isShowPagination &&
        <Pagination
          onPageChange={(page) => handleSetPage(page)}
          currentPage={page}
          itemsPerPage={perPage}
          totalItems={total}
          maxSiblings={5}
        />
      }

      {isLoading
        ? <Loading/>
        : !posts.length
          ? <div>List is empty yet</div>
          : renderList()
      }
    </div>
  )
}

Posts.propTypes = {
  posts: PropTypes.array.isRequired,
  isLoading: PropTypes.bool.isRequired,
  page: PropTypes.number.isRequired,
  perPage: PropTypes.number.isRequired,
  total: PropTypes.number.isRequired,
  handleSetPage: PropTypes.func.isRequired,
  isShowTitle: PropTypes.bool.isRequired,
  isShowPagination: PropTypes.bool.isRequired
}

export default Posts
