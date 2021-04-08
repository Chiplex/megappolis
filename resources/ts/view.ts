class View {
    public init ():string{
        return "Hello world!";
    }
    public close():string{
        return "close";
    }
}

const view = new View();
export default view;