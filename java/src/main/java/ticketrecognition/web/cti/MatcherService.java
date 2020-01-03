package ticketrecognition.web.cti;

import com.bfh.ticket.*;
import com.bfh.ticket.exception.CtiException;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.HashMap;
import java.util.Map;
import java.util.Optional;
import java.util.logging.Logger;

public class MatcherService {

    private static final Logger LOG = Logger.getLogger(MatcherService.class.getName());

    private final Matcher matcher;
    private final Map<String, Ticket> currentTemplates;

    public MatcherService() {
        this.matcher = new Matcher(Algorithm.SIFT);
        this.currentTemplates = new HashMap<>();
    }

    public void train(Ticket ticket) {
        try {
            matcher.train(ticket);
            currentTemplates.put(ticket.getName(), ticket);
        } catch (CtiException exc) {
            LOG.severe(exc.getMessage());
        }
    }

    public void untrain(String templateName) {
        if (!currentTemplates.containsKey(templateName)) {
            LOG.warning("Template with key: " + templateName + " does not exist");
            return;
        }

        try {
            Ticket ticket = currentTemplates.get(templateName);
            Files.delete(Paths.get(ticket.getImage().getImagePath()));
            matcher.untrain(ticket);
            currentTemplates.remove(templateName);
            LOG.info("Untrained template: " + templateName);
        } catch(CtiException | IOException exc) {
            LOG.severe(exc.getMessage());
        }
    }

    public Optional<TicketMatch> match(TicketImage image) {
        return matcher.match(image);
    }
}
