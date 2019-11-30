package ticketrecognition.web.cti;

import com.bfh.ticket.*;

public class ReaderService {

    private final MetadataReader reader;

    public ReaderService() {
        Cti cti = new Cti();
        this.reader = cti.reader(Algorithms.SIFT.name());
    }

    public Metadata read(Ticket ticket, TicketImage ticketImage) {
        return reader.read(ticket, ticketImage);
    }
}
