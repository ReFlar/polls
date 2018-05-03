import Modal from 'flarum/components/Modal';
import avatar from 'flarum/helpers/avatar';
import username from 'flarum/helpers/username';

export default class ShowVotersModal extends Modal {

    init() {
        console.log(this.props)
    }

    className() {
        return 'Modal--small';
    }

    title() {
        return app.translator.trans('reflar-polls.forum.votes_modal.title');
    }

    content() {
        return (
            <div className="Modal-body">
                <ul className="VotesModal-list">
                    {this.props.answers().map(answer => (
                        <div>
                            <legend>{answer.answer()}</legend>
                            {this.props.votes().forEach(vote => (
                                <div>
                                    {answer.id() === vote.option_id() ? user = app.store.getById('users', vote.user_id())(
                                        <li>
                                            <a href={app.route.user(user)} config={m.route}>
                                                {avatar(user)} {' '}
                                                {username(user)}
                                            </a>
                                        </li>
                                    ) : ''}
                                </div>
                            ))}
                        </div>
                    ))}
                </ul>
            </div>
        )
    }
}