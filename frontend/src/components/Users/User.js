import React from 'react'
import { useNavigate } from 'react-router'
import Loading from '../../baseComponents/loading/Loading'
import Posts from '../Posts/Posts'
import PropTypes from 'prop-types'

function User (params) {
  const {
    isLoading,
    user
  } = params

  const navigate = useNavigate()

  if (!user || isLoading) {
    return <Loading/>
  }

  return (
    <div className="user">
      <div className="supermetrics-app__navigation">
        <a onClick={() => navigate(-1)} className="btn">&larr; Go back</a>
      </div>
      <h1>{user.user.name} statistics</h1>
      <div className="user__statistics">
        <div className="user__statistics-item">
          <div className="user__statistics-item-name">
            The number of posts made in total:
          </div>
          <div className="user__statistics-item-value">
            {user.userPostsCount}
          </div>
        </div>

        <div className="user__statistics-item">
          <div className="user__statistics-item-name">
            Average number of characters:
          </div>
          <div className="user__statistics-item-value">
            {user.avgMessageLength}
          </div>
        </div>

        <div className="user__statistics-item">
          <div className="user__statistics-item-name">
            The number of posts made every month:
          </div>
          <div className="user__statistics-item-value">
            <div className="table">
              <div className="table__head">
                <div className="table__cell">Month</div>
                <div className="table__cell">Count</div>
              </div>
              {user.postsByMonth && user.postsByMonth.map((item) =>
                <div className="table__row" key={item['month']}>
                  <div className="table__cell">{item['month']}</div>
                  <div className="table__cell">{item['posts_count']}</div>
                </div>
              )}
            </div>
          </div>
        </div>

        <div className="user__statistics-item">
          <div className="user__statistics-item-name">
            Longest post:
          </div>
          <div className="user__statistics-item-value">
            <Posts
              posts={[user.maxMessagePost]}
              isLoading={false}
              page={1}
              perPage={1}
              total={1}
              handleSetPage={() => {}}
              isShowTitle={false}
              isShowPagination={false}
            />
          </div>
        </div>
      </div>
    </div>
  )
}

User.propTypes = {
  user: PropTypes.object.isRequired,
  isLoading: PropTypes.bool.isRequired,
}

export default User
