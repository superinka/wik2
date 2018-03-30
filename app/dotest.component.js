
function parseJwt(token) {
	var base64Url = token.split('.')[1];
	var base64 = base64Url.replace('-', '+').replace('_', '/');
	return JSON.parse(window.atob(base64));
};
function shuffle(array) {
    let counter = array.length;

    // While there are elements in the array
    while (counter > 0) {
        // Pick a random index
        let index = Math.floor(Math.random() * counter);

        // Decrease counter by 1
        counter--;

        // And swap the last element with it
        let temp = array[counter];
        array[counter] = array[index];
        array[index] = temp;
    }

    return array;
}
//console.log(parseJwt(localStorage.token));

const str = window.location.pathname;
const res = str.split("/");
const test_id = res[3];
var token = parseJwt(localStorage.token);
//console.log(token);
//var url = "http://wiki.com/api/quiz/tests";

var CountdownTimer = React.createClass({
	getInitialState: function () {
		return {
			secondsRemaining: 0,
		};
	},
	componentWillReceiveProps(nextProps) {
		if (nextProps.secondsRemaining != this.state.secondsRemaining) {
			this.setState({ secondsRemaining: nextProps.secondsRemaining });
		}
	},

	tick: function () {
		this.setState({ secondsRemaining: this.state.secondsRemaining - 1 });
		if (this.state.secondsRemaining >= 0) {
			this.submitToServer();
		}
		var u = window.location.origin + "/quiz/end_test/" +test_id ;
		if((this.state.secondsRemaining == 0) && (this.props.duration > 0) ){
			window.location.replace(u);
		}
		
		if (this.state.secondsRemaining <= 0) {
			clearInterval(this.interval);
		}
	},
	submitToServer: function () {
		//console.log(this.props.results);
		//console.log(this.state.secondsRemaining);
		var u = window.location.origin;
		axios.post(u + '/api/quiz/infotesttime', {
			test_id: test_id,
			user_id: token.id,
			time_left: this.state.secondsRemaining
		}, {
				headers: {
					'Authorization': "Bearer " + localStorage.token
				}
			})
			.then((result) => {
				console.log(result.data);
			})
			.catch(function (error) {
				console.log(error);
			});
	},
	componentDidMount: function () {
		this.setState({ secondsRemaining: this.props.secondsRemaining });
		if(this.props.secondsRemaining > 0){
			this.interval = setInterval(this.tick, 60000);
		}
	
	},
	componentWillUnmount: function () {
		clearInterval(this.interval);
	},
	render: function () {
		return (
			<div>Thời gian còn lại: {this.state.secondsRemaining}</div>
		);
	}
});

const QuestionGrid = React.createClass({
	getInitialState: function () {
		return { 
			active: this.props.result,
			result: this.props.result,
		};
		//this.radioClick = this.radioClick.bind(this);
	},
	radioClick: function (e) {
		var question_id = this.props.question.question_id;
		this.setState({ active: e.target.value, result: e.target.value }, () => this.props.final([question_id,this.state.result]));
	},
	
	render: function () {
		//console.log(this.state.result);
		var rows = [];
		var chosen = this.props.question.result;
		//console.log(chosen);

		var question_id = this.props.question.question_id;
		var list_answer = this.props.question.list_answer;

		var self = this;
		list_answer.map(function (answer,index) {

			rows.push(
				<div key={answer.answer_id} >
					{/* <AnswerGrid key={answer.answer_id} answer={answer}  /> */}
					<input type="radio" name={question_id} 
                                        value={answer.answer_id}
										checked={self.state.active === answer.answer_id } 
                                        onChange={self.radioClick}
									    key={answer.answer_id} />
					<label className="radioCustomLabel">{answer.title}</label>
				</div>
			);
		});
		//console.log(self.state.result);
	
		return (
			<div className="row">
				<div className="col-md-12">
					<h3 className="question"><b>{this.props.question.question_title}</b></h3>
					<ul className="answerOptions">
						{rows}
					</ul>
					<hr />
				</div>
			</div>
		);
	}
});



const MainApp = React.createClass({


	getInitialState: function () {
		return {
			test: [],
			info: [],
			time_left: 60, //60
			test_key: "",
			questions: [],
			results :[],
			result:"",
			final:"",
			duration : 0
		}
	},
	componentDidMount: function () {
		this.loadTestFromServer();
	},
	loadTestFromServer: function () {
		var ux = window.location.origin;
		var url= ux + "/api/quiz/infotest/";
		var api_url = url + test_id;
		axios.get(api_url,
			{
				headers: {
					'Authorization': "Bearer " + localStorage.token
				}
			})
			.then((test) => {
				//console.log(shuffle(test.data.question));
				var time = test.data.info.time_left;
				var duration = test.data.info.duration;
				//var question =  test.data.question;
				this.setState({ test: test.data, info: test.data.info, time_left: time, duration: duration, questions: shuffle(test.data.question)});
				this.setState({ results: test.data.result});
			})
			.catch(function (error) {
				console.log(error);
			});
	},
	setValue(value) {
		this.submitone(value);
	},
	submitone: function (value) {
		//console.log(this.props.results);
		//console.log(this.state.secondsRemaining);
		const str = window.location.pathname;
		const res = str.split("/");
		const test_id = res[3];
		var u = window.location.origin;

		axios.post(u+ '/api/quiz/infotestresult', {
			test_id: test_id,
			user_id: token.id,
			data : value

		}, 
		{
				headers: {
					'Authorization': "Bearer " + localStorage.token
				}
			})
			.then((result) => {
				console.log(result.data);
			})
			.catch(function (error) {
				console.log(error);
			});
	},
	render: function () {
		var rows = [];
		var dem=0;
		var self = this;
		var b_url = window.location.origin;
		var end_url = b_url + "/quiz/end_test/";

		this.state.questions.map(function (question) {
			//console.log(question.result);
			var re = question.result;
			var res = re.split("-");

			rows.push(<QuestionGrid key={question.question_id} question={question} result={res[1]} final={self.setValue} />);				
		});
		return (

			<div>
				<div className="container">
					<a href={end_url + test_id}>
						<button type="button" className="btn btn-primary">KẾT THÚC</button>
					</a>
				</div>
				<hr/>
				<div className="container">
					<CountdownTimer secondsRemaining={this.state.time_left} duration={this.state.duration} results= {this.state.results} />
				</div>
				<div className="container">

					{rows}

				</div>
			</div>
		);
	}
});

ReactDOM.render(
	<MainApp />,
	document.getElementById('app')
);