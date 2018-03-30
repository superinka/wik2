
const TestGridRow = React.createClass({
	render: function () {
		var base_url = window.location.origin;
		var test_url = base_url + "/quiz/do_test/";

		var duration = (this.props.test.duration == 0) ? "Không Giới Hạn":this.props.test.duration + " Phút";
		var status = this.props.titleButton;
		var status_text = "Bắt Đầu";
		if(status==1) {status_text = "Làm Tiếp"};
		if(status==2) {status_text = "Xem Điểm"}
		return (
			<div className="col-md-6 col-xs-12">
				<a href={this.props.test.id}><h3 className="test-title">{this.props.test.description}</h3></a>
				<p><i>{this.props.test.created_at}</i> bởi <b>{this.props.test.creator}</b></p>
				<p>{duration}</p>
				<p>{this.props.test.number_of_question} câu hỏi</p>
				{/* <button type="button" className="btn btn-primary"><a data-toggle="modal" href="" data-target="#myModal">Bắt Đầu</a></button> */}
				<a href={test_url + this.props.test.test_id}>
					<button type="button" className="btn btn-primary">{status_text}</button>
				</a>
			</div>
		);
	}
});

const InfoTest = React.createClass({
	render: function () {
		return (
			<div>
				<div className="col-md-6">
					<div className="h-service">
						<div className="icon-wrap ico-bg round-fifty">
							<i className="fa fa-question">
							</i>
						</div>
						<div className="h-service-content">
							<h3>{this.props.test.tester}</h3>
							<p>Bắt đầu: {this.props.test.start_at}<br/>
							Kết thúc: {this.props.test.end_at}<br/>
							Điểm số: {this.props.test.total_point}<br/>
							Tình trạng : {this.props.test.status_text}</p>
						</div>
					</div>
				</div>
			</div>
		);
	}
});

function parseJwt(token) {
	var base64Url = token.split('.')[1];
	var base64 = base64Url.replace('-', '+').replace('_', '/');
	return JSON.parse(window.atob(base64));
};
//console.log(parseJwt(localStorage.token));

const str = window.location.pathname;
const res = str.split("/");
const test_id = res[3];
var token = parseJwt(localStorage.token);
//console.log(token);
var url = "http://wiki.com/api/quiz/tests";

const MainApp = React.createClass({

	getInitialState: function () {
		return {
			test: [],
			titleButton: "Bắt Đầu",
		}
	},
	componentDidMount: function () {
		this.loadTestFromServer();
	},
	loadTestFromServer: function () {
		var u = window.location.origin;
		axios.post( u + '/api/quiz/tests', {
			test_id: test_id,
			user_id: token.id
		}, {
				headers: {
					'Authorization': "Bearer " + localStorage.token
				}
			})
			.then((test) => {
				console.log(test.data);
				this.setState({ test: test.data, status:test.data.status,status_text:test.data.status_text});
			})
			.catch(function (error) {
				console.log(error);
			});
	},
	render: function () {

		return (
			<div>
				<div className="container">
					<div className="row">
						<TestGridRow key={this.state.test.id} test={this.state.test} titleButton={this.state.status} />
						<InfoTest test={this.state.test} />
					</div>
				</div>
			</div>
		);
	}
});

ReactDOM.render(
	<MainApp />,
	document.getElementById('app')
);