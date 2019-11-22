package ticketrecognition.web.matcher;

import com.bfh.ticket.*;

import java.util.Optional;

public class MatcherService {

    private final Matcher matcher;

    public MatcherService() {
        Cti cti = new Cti();
        this.matcher = cti.matcher(Algorithms.SIFT.name());
    }

    public void train(Ticket ticket) {
        matcher.train(ticket);
    }

    public Optional<TicketMatch> match(TicketImage image) {
        return matcher.match(image);
    }
}
