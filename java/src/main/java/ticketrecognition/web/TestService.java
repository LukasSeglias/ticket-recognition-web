package ticketrecognition.web;

public class TestService {

    TestClass testObj() {
        TestClass test = new TestClass();
        test.setId(123L);
        test.setTest("TEST TEST");
        TestClass.OtherClass other = new TestClass.OtherClass();
        other.setName("Hallo");
        test.setOther(other);
        return test;
    }

}
