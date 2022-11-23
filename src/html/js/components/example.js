import $ from 'jquery';

const selectSomething = function() {
	return $( '.something' );
};

export default ( a, b ) => a + b;
export {
	selectSomething,
};
