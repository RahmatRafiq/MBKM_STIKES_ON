import Navbar from "@/Components/Navbar";

type Props = {
  children: React.ReactNode;
  className?: string;
}

const Guest = ({ children, className }: Props) => {

  return (
    <>
      <Navbar />
      <main className={className}>
        {children}
      </main>
    </>
  );
}

export default Guest;
