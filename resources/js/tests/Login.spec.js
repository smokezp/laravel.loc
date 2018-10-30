import Login from '../components/Login';

describe('Editor', () => {
    it('should set correct default data', function () {
        expect(typeof Login.data).toBe('function')
        // var defaultData = Editor.data()
        // expect(defaultData.input).toBe('# Hello!')
    });
});
