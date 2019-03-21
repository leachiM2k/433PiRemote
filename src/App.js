import Preact from 'preact';

const get = url => {
    return fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Something went wrong ...');
            }
        });
};

const highlight = color => {
    document.getElementsByTagName("body")[0].animate([
        // keyframes
        { backgroundColor: color },
        { backgroundColor: 'transparent' }
    ], {
        // timing options
        duration: 250
    });
};

class App extends Preact.Component {
    constructor() {
        super();
        let initialState = {
            data: [],
            groups: [],
            baseUrl: ''
        };
        this.state = window._seed || initialState;
    }

    componentDidMount() {
        this.getFreshData();
    }

    getFreshData() {
        get('/api')
            .then(data => this.setState({
		    data,
                /*data: data.data,
                groups: data.groups,
                baseUrl: data.baseUrl,*/
                isLoading: false
            }))
            .catch(error => this.setState({ error, isLoading: false }));
    }

    handleActionClick = event => {
        event.preventDefault();
        const target = event.target;
        get(target.href).then(data => {
            highlight(data.result === "success" ? '#008800' : '#880000');
        }).catch(err => {
            highlight('#880000');
        });
    };

    render() {
        const { data, groups, baseUrl } = this.state;

        return (
            <div className="container">
                <h1>433PiRemote</h1>
                <div id="remotes" className="section">
                    {data.map((item, id) => (
                        <div>
                            <h2>{item.name}</h2>
                            <div className="row buttons">
                                <div className="col-xs-6">
                                    <a className="btn btn-danger btn-block switch"
                                       onClick={this.handleActionClick}
                                       href={`${baseUrl}/api/switch?id=${id}&action=off`}>aus</a>
                                </div>
                                <div className="col-xs-6">
                                    <a className="btn btn-success btn-block switch"
                                       onClick={this.handleActionClick}
                                       href={`${baseUrl}/api/switch?id=${id}&action=on`}>an</a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {/*
                <div style="margin-top: 20px">
                    <nav className="navbar navbar-default navbar-collapse" role="navigation">
                        <ul className="nav navbar-nav sectionTrigger">
                            <li className="active"><a href="#remotes">Einzeln</a></li>
                            <li><a href="#groups">Gruppen</a></li>
                        </ul>
                        <ul className="nav navbar-nav navbar-right">
                            <li><a href={`${baseUrl }/admin/`}>Verwaltung</a></li>
                        </ul>
                    </nav>
                </div>
                */}
            </div>
        );
    }
}

export default App;
