
const Quiz = React.createClass({
    renderAnswerOptions(key) {
        return (
          <AnswerOption
            key={key.content}
            answerContent={key.content}
            answerType={key.type}
            answer={props.answer}
            questionId={props.questionId}
            onAnswerSelected={props.onAnswerSelected}
          />
        );
      },
    
      return (
        <ReactCSSTransitionGroup
          className="container"
          component="div"
          transitionName="fade"
          transitionEnterTimeout={800}
          transitionLeaveTimeout={500}
          transitionAppear
          transitionAppearTimeout={500}
        >
          <div key={props.questionId}>
            <QuestionCount
              counter={props.questionId}
              total={props.questionTotal}
            />
            <Question content={props.question} />
            <ul className="answerOptions">
              {props.answerOptions.map(renderAnswerOptions)}
            </ul>
          </div>
        </ReactCSSTransitionGroup>
      );
    }
    
    Quiz.propTypes = {
      answer: React.PropTypes.string.isRequired,
      answerOptions: React.PropTypes.array.isRequired,
      question: React.PropTypes.string.isRequired,
      questionId: React.PropTypes.number.isRequired,
      questionTotal: React.PropTypes.number.isRequired,
      onAnswerSelected: React.PropTypes.func.isRequired
    };

});


const MainApp = React.createClass({
    getInitialState: function () {
		return {
            counter: 0,
            questionId: 1,
            question: '',
            answerOptions: [],
            answer: '',
            answersCount : {},
            result: '',
            questions: []
            
        }
        this.handleAnswerSelected = this.handleAnswerSelected.bind(this);
    },
    componentWillMount: function () {
		this.loadTestFromServer();
	},
	loadTestFromServer: function () {
		axios.get('http://wiki.com/api/quiz/infotest/7',
			{
				headers: {
					'Authorization': "Bearer " + localStorage.token
				}
			})
			.then((test) => {
				var time = test.data.info.time_left;
				this.setState({ test: test.data, info: test.data.info, time_left: time, questions: test.data.question });
			})
			.catch(function (error) {
				console.log(error);
            });
	},
    componentDidMount() {
        console.log(this.props.questions);

        const shuffledAnswerOptions = quizQuestions.map((question) => this.shuffleArray(question.answers));
        this.setState({
          question: quizQuestions[0].question,
          answerOptions: shuffledAnswerOptions[0]
        });
      },
    
      shuffleArray(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;
    
        // While there remain elements to shuffle...
        while (0 !== currentIndex) {
    
          // Pick a remaining element...
          randomIndex = Math.floor(Math.random() * currentIndex);
          currentIndex -= 1;
    
          // And swap it with the current element.
          temporaryValue = array[currentIndex];
          array[currentIndex] = array[randomIndex];
          array[randomIndex] = temporaryValue;
        }
    
        return array;
      },
    
      handleAnswerSelected(event) {
        this.setUserAnswer(event.currentTarget.value);
    
        if (this.state.questionId < quizQuestions.length) {
            setTimeout(() => this.setNextQuestion(), 300);
        } else {
            setTimeout(() => this.setResults(this.getResults()), 300);
        }
      },
    
      setUserAnswer(answer) {
        const updatedAnswersCount = update(this.state.answersCount, {
          [answer]: {$apply: (currentValue) => currentValue + 1}
        });
    
        this.setState({
            answersCount: updatedAnswersCount,
            answer: answer
        });
      },
    setNextQuestion() {
        const counter = this.state.counter + 1;
        const questionId = this.state.questionId + 1;
    
        this.setState({
            counter: counter,
            questionId: questionId,
            question: quizQuestions[counter].question,
            answerOptions: quizQuestions[counter].answers,
            answer: ''
        });
      },

    renderQuiz() {
        return (
            <Quiz
                answer={this.state.answer}
                answerOptions={this.state.answerOptions}
                questionId={this.state.questionId}
                question={this.state.question}
                questionTotal={quizQuestions.length}
                onAnswerSelected={this.handleAnswerSelected}
            />
        );
    },

    render: function () {
        return (

            <div>
                {this.renderQuiz()}
            </div>
        );
    }
});

ReactDOM.render(
    <MainApp />,
    document.getElementById('app')
);