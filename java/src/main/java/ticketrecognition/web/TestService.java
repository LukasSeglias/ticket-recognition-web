package ticketrecognition.web;

import javax.ejb.Stateless;

@Stateless
public class TestService {

    public TestClass testObj() {
        TestClass test = new TestClass();
        test.setId(123L);
        test.setTest("TEST TEST");
        TestClass.OtherClass other = new TestClass.OtherClass();
        other.setName("Hallo");
        test.setOther(other);
        return test;
    }

}
